<template>
	<div>
		<div class="mb-3">
			<span v-if="section">
				<span v-if="section.category">
					<a :href="'/' + section.category.slug">{{ section.category.name }}</a> > {{ section.name }}
				</span>
				<span v-else>{{ section.name }}</span>
				<small class="p-1 ml-2 mr-5 rounded" style="background-color: aliceblue;">{{ count }}</small>
			</span>

			Price:
			<input type="text"
				v-model="filter.minimum"
				@keyup="stoppedTyping"
				class="form-control-sm ml-1 text-center text-size-sm"
				style="width: 70px;"
				placeholder="from">
			<input type="text"
				v-model="filter.maximum"
				@keyup="stoppedTyping"
				class="form-control-sm ml-1 mr-5 text-center text-size-sm"
				style="width: 70px;"
				placeholder="to">
			Sort By:
			<select v-model="filter.sortOrder" @change="stoppedTyping" class="form-control-sm ml-2">
				<option value="newFirst">Newest</option>
				<option value="descending">Price Descending</option>
				<option value="ascending">Price Ascending</option>
			</select>
			<div v-if="section && section.sections" class="mt-2">
				<a v-for="item in section.sections"
					:href="'/' + section.slug + '/' + item.slug"
					class="text-size-sm hover-background mr-3">{{ item.name }}</a>
			</div>
			<div v-if="!section" class="mt-2">
				<span class="text-size-sm">
					<a :href="'/search?searchTerm=' + query + '&city=' + city + '&categorySearch=' + category.id"
						v-for="category in filter.categories"
						class="mr-1"
					>
						{{ category.name }}
						<small class="p-1 ml-2 mr-5 rounded" style="background-color: aliceblue;">{{ category.ads.length }}</small>
					</a>
				</span>
			</div>
		</div>
		<div class="lds-hourglass mt-5" v-if="isLoading"></div>
		<tabs @active="toggleCollections" v-show="!isLoading">
			<tab name="Private" :selected="filter.privateAds.length > 0 ? true : false">
				<featured-ad-card :ads="filter.filteredFeaturedPrivate ? filter.filteredFeaturedPrivate : filter.privateFeatured">
				</featured-ad-card>

		        <div class="row">
					<div class="col-lg-8">
						<ad-card :ads="filter.filteredPrivate ? filter.filteredPrivate : filter.privateAds"></ad-card>
					</div>
				</div>
			</tab>
			<tab name="Business" :selected="filter.privateAds.length == 0 ? true : false">
				<featured-ad-card :ads="filter.filteredFeaturedBusiness ? filter.filteredFeaturedBusiness : filter.businessFeatured">
				</featured-ad-card>

		       <div class="row">
					<div class="col-lg-8">
						<ad-card :ads="filter.filteredBusiness ? filter.filteredBusiness : filter.businessAds"></ad-card>
					</div>
				</div>

				<div v-if="filter.empty">There are no items matching the given criteria. Try to expand the filters.</div>
			</tab>
		</tabs>
	</div>
</template>

<script>
import AdFilters from '../AdFilters.js';
import FeaturedAdCard from './partialComponents/FeaturedAdCard.vue';
import AdCard from './partialComponents/AdCard.vue';

export default {
	components: { FeaturedAdCard, AdCard },

	props: ['section', 'private', 'business', 'count'],

	data() {
		return {
			filter: new AdFilters({
				minimum: '',
				maximum: '',
				filteredPrivate: null,
				filteredBusiness: null,
				filteredFeaturedPrivate: null,
				filteredFeaturedBusiness: null,
				private: this.private,
				business: this.business,
				collections: {
					normalAds: '',
					featuredAds: '',
					filteredAds: '',
					filteredFeatured: ''
				},
				sortOrder: 'newFirst',
				empty: false,
				indexedCategories: {},
				categories: []
			}),
			timeout: '',
			isLoading: false,
			query: new URL(location.href).searchParams.get('searchTerm'),
			city: new URL(location.href).searchParams.get('city')
		};
	},

	created() {
		if (! this.section) {
			this.groupBy();
		}
		if (this.filter.business.length == 0) {
			this.filter.empty = true;
		}
	},

	methods: {
		toggleCollections(tabName, shouldFilter) {
			let name = tabName.toLowerCase();

			this.filter.collections = {
				normalAds: name + 'Ads',
				featuredAds: name + 'Featured',
				filteredAds: 'filtered' + tabName,
				filteredFeatured: 'filteredFeatured' + tabName
			};

			if (shouldFilter) {
				this.minimumPrice();
			}
		},

		groupBy() {
			var allAds = {...this.private, ...this.business};
			allAds = Object.values(allAds);

			this.filter.groupBy(allAds);
		},

		loading(expression1, expression2) {
			clearTimeout(this.timeout);
			this.isLoading = true;
			this.timeout = setTimeout(() => {
				if (expression1 == undefined) {
					this.minimumPrice();
				}
				expression1;
				expression2;
				this.isLoading = false;
			}, 1000);
		},

		stoppedTyping() {
			this.loading();
		},

		minimumPrice() {
			if (this.filter.minimum) {
				this.filter.priceFilter(
					this.filter[this.filter.collections.normalAds],
					this.filter[this.filter.collections.featuredAds],
					this.filter.minimum,
					function(adPrice, userInput) { return adPrice >= userInput }
				);

				this.maxPrice(
					this.filter[this.filter.collections.filteredAds],
					this.filter[this.filter.collections.filteredFeatured]
				);
			} else {
				this.reset();

				this.maxPrice(
					this.filter[this.filter.collections.normalAds],
					this.filter[this.filter.collections.featuredAds]
				);
			}
		},

		maxPrice(filteredAds, filteredFeatured) {
			if (this.filter.maximum) {
				this.filter.priceFilter(
					filteredAds,
					filteredFeatured,
					this.filter.maximum,
					function(adPrice, userInput) { return adPrice <= userInput }
				);

				this.sortingOrder(
					this.filter[this.filter.collections.filteredAds],
					this.filter[this.filter.collections.filteredFeatured]
				);
			} else {
				this.sortingOrder(filteredAds, filteredFeatured);
			}
		},

		sortingOrder(filteredAds, filteredFeatured) {
			if (!filteredAds && !filteredFeatured) {
				return this.filter.empty = true;
			}

			this.filter.sortFilter(filteredAds, filteredFeatured);
		},

		reset() {
			this.filter[this.filter.collections.filteredAds] = null;
			this.filter[this.filter.collections.filteredFeatured] = null;
		}
	}
};
</script>

<style>
	.lds-hourglass {
	  display: inline-block;
	  position: relative;
	  width: 80px;
	  height: 80px;
	  left: 460px;
	}
	.lds-hourglass:after {
	  content: " ";
	  display: block;
	  border-radius: 50%;
	  width: 0;
	  height: 0;
	  margin: 8px;
	  box-sizing: border-box;
	  border: 62px solid #fff;
	  border-color: #30e3ca transparent #30e3ca transparent;
	  animation: lds-hourglass 1.2s infinite;
	}
	@keyframes lds-hourglass {
	  0% {
	    transform: rotate(0);
	    animation-timing-function: cubic-bezier(0.55, 0.055, 0.675, 0.19);
	  }
	  50% {
	    transform: rotate(900deg);
	    animation-timing-function: cubic-bezier(0.215, 0.61, 0.355, 1);
	  }
	  100% {
	    transform: rotate(1800deg);
	  }
	}

	.text-size-sm {
	    font-size: .65rem !important;
	}
	.hover-background:hover {
		background-color: aliceblue;
		border-radius: 45px;
	}
</style>
