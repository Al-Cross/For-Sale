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
			<br>
			Price:
			<input type="text"
				v-model="filter.minimum"
				@keyup="stoppedTyping"
				class="form-control-sm ml-1 mt-4 text-center text-size-sm"
				style="width: 70px;"
				placeholder="from">
			<input type="text"
				v-model="filter.maximum"
				@keyup="stoppedTyping"
				class="form-control-sm ml-1 mr-3 text-center text-size-sm"
				style="width: 70px;"
				placeholder="to">
			Sort By:
			<select v-model="filter.sortOrder" @change="stoppedTyping" class="form-control-sm ml-2 mr-3">
				<option value="newFirst">Newest</option>
				<option value="descending">Price Descending</option>
				<option value="ascending">Price Ascending</option>
			</select>
			Delivery is on:
			<select v-model="filter.delivery" @change="stoppedTyping" class="form-control-sm ml-2 mr-3">
				<option value="all">All</option>
				<option value="buyer">Buyer</option>
				<option value="seller">Seller</option>
				<option value="personal handover">Personal Handover</option>
			</select>
			Condition:
			<select v-model="filter.condition" @change="stoppedTyping" class="form-control-sm ml-2">
				<option value="any">Any</option>
				<option value="new">New</option>
				<option value="used">Used</option>
			</select>
			<div v-if="section && section.sections" class="mt-2">
				<a v-for="item in section.sections"
					:href="'/' + section.slug + '/' + item.slug"
					class="text-size-sm hover-background mr-3">{{ item.name }}</a>
			</div>
			<div v-if="!section" class="mt-2">
				<span class="text-size-sm">
					<small class="text-primary mr-5">
						All {{ tabName }}
						<span class="p-1 ml-2 rounded" style="background-color: aliceblue;">{{ adsCount }}</span>
					</small>
					<a :href="'/search?searchTerm=' + query + '&city=' + city + '&distance=' + distance + '&categorySearch=' + category.id"
						v-for="category in filter.categories"
						class="mr-1"
					>
						{{ category.name }}
						<small class="p-1 ml-2 mr-5 rounded" style="background-color: aliceblue;" v-text="category.ads.length"></small>
					</a>
				</span>
			</div>
		</div>
		<div class="lds-hourglass mt-5" v-if="isLoading"></div>
		<tabs @active="toggleCollections" v-show="!isLoading">
			<tab name="Private" :selected="tabOnPageLoad">
				<featured-ad-card :ads="filter.filteredFeaturedPrivate ? filter.filteredFeaturedPrivate : filter.privateFeatured">
				</featured-ad-card>

		        <div class="row">
					<div class="col-lg-8">
						<ad-card :ads="filter.filteredPrivate ? filter.filteredPrivate : filter.privateAds"></ad-card>
					</div>
				</div>

				<div v-if="filter.empty">There are no items matching the given criteria. Try to expand the filters.</div>
			</tab>
			<tab name="Business" :selected="!tabOnPageLoad">
				<featured-ad-card :ads="filter.filteredFeaturedBusiness ? filter.filteredFeaturedBusiness : filter.businessFeatured">
				</featured-ad-card>

		       <div class="row">
					<div class="col-lg-8">
						<ad-card :ads="filter.filteredBusiness ? filter.filteredBusiness : filter.businessAds"></ad-card>
					</div>
				</div>

				<div v-if="filter.empty || filter.emptyBusiness">There are no items matching the given criteria. Try to expand the filters.</div>
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
				delivery: 'all',
				condition: 'any',
				empty: false,
				emptyBusiness: false,
				indexedCategories: {},
				categories: []
			}),
			timeout: '',
			isLoading: false,
			query: new URL(location.href).searchParams.get('searchTerm'),
			city: new URL(location.href).searchParams.get('city'),
			distance: parseInt(new URL(location.href).searchParams.get('distance')) || '',
			adsCount: '',
		};
	},

	created() {
		if (this.filter.business.length == 0) {
			this.filter.emptyBusiness = true;
		}
	},

	computed: {
		tabOnPageLoad() {
			if (typeof this.private === 'object') {
				return Object.keys(this.private).length > 0 ? true : false;
			}

			return this.private.length > 0 ? true : false;
		},

		tabName() {
			return this.filter.collections.normalAds === 'privateAds' ? 'private ads' : 'business ads';
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

			if (! this.section) {
				this.groupBy(name);
			}

			this.adsFound();

			if (shouldFilter) {
				this.filterDelivery();
			}
		},

		groupBy(tab) {
			var adsInTab = Object.values(this[tab]);

			this.filter.groupBy(adsInTab);
		},

		loading() {
			clearTimeout(this.timeout);
			this.isLoading = true;

			this.timeout = setTimeout(() => {
				this.filterDelivery();
				this.isLoading = false;
			}, 1000);
		},

		stoppedTyping() {
			this.loading();
		},

		filterDelivery() {
			this.filter.deliveryFilter(
				this.filter[this.filter.collections.normalAds],
				this.filter[this.filter.collections.featuredAds],
			);

			this.filterCondition(
				this.filter[this.filter.collections.filteredAds],
				this.filter[this.filter.collections.filteredFeatured]
			);
		},

		filterCondition(filteredAds, filteredFeatured) {
			this.filter.conditionFilter(filteredAds, filteredFeatured);

			this.minimumPrice(
				this.filter[this.filter.collections.filteredAds],
				this.filter[this.filter.collections.filteredFeatured]
			);
		},

		minimumPrice(filteredAds, filteredFeatured) {
			if (this.filter.minimum) {
				this.filter.priceFilter(
					filteredAds,
					filteredFeatured,
					this.filter.minimum,
					function(adPrice, userInput) { return adPrice >= userInput }
				);

				this.maxPrice(
					this.filter[this.filter.collections.filteredAds],
					this.filter[this.filter.collections.filteredFeatured]
				);
			} else {
				this.maxPrice(
					this.filter[this.filter.collections.filteredAds],
					this.filter[this.filter.collections.filteredFeatured]
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
			var filteredAll = filteredAds.concat(filteredFeatured);

			if (!filteredAll) {
				return this.filter.empty = true;
			}

			this.filter.sortFilter(filteredAds, filteredFeatured);
			this.adsFound();

			filteredAll = Object.values(filteredAll);
			this.filter.groupBy(filteredAll);
		},

		adsFound() {
			let filteredAds = this.filter[this.filter.collections.filteredAds];
			let filteredFeaturedAds = this.filter[this.filter.collections.filteredFeatured];
			let originalAds = this.filter[this.filter.collections.normalAds];
			let originalFeaturedAds = this.filter[this.filter.collections.featuredAds];

			this.adsCount = filteredAds || filteredFeaturedAds
				? filteredAds.length + filteredFeaturedAds.length
				: originalAds.length + originalFeaturedAds.length;
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
