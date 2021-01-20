<template>
	<div>
		<tabs class="mt-3">
			<tab name="Ads" :selected="true">
				<i class="fas fa-search mt-3"></i>
				<input type="text"
						v-model="searchTerm"
						@keyup="search"
						class="form-control-sm ml-1 text-center text-size-sm mr-5"
						style="width: 170px;"
						placeholder="Search">
				Sort By:
				<select v-model="filter.sortOrder" @change="sortAds" class="form-control-sm ml-2">
					<option value="newFirst">Newest</option>
					<option value="descending">Price Descending</option>
					<option value="ascending">Price Ascending</option>
				</select>
				<div class="mt-2">
					<span v-if="!nothingFound" class="text-size-sm" style="font-size: 17px;">
						<a href="#" @click.prevent="seeAllAds" :class="inactiveState">
							See all
							<small class="p-2 ml-2 mr-5 rounded color-box">{{ adsCount }}</small>
						</a>
						<a href="#"
							v-for="category in filter.categories"
							@click.prevent="showInCategory(category)"
							:class="activeState(category.id)"
						>
							{{ category.name }}
							<small class="p-2 ml-2 mr-5 rounded color-box">{{ category.ads.length }}</small>
						</a>
					</span>
				</div>
				<hr>
				<featured-ad-card :ads="filter.filteredFeatured ? filter.filteredFeatured : featuredAds"></featured-ad-card>
				 <div class="row">
					<div class="col-lg-8">
						<ad-card :ads="filter.filteredNormal ? filter.filteredNormal : normalAds"></ad-card>
					</div>
				</div>
				<div v-if="nothingFound">Nothing found.</div>
			</tab>
			<tab name="About Us">
				<span v-text="user.about" class="card shadow-lg mt-3 p-5"></span>
			</tab>
			<tab name="Contact">
				<label for="address" class="font-weight-bold mt-3">Address</label>
				<span v-text="user.address" class="card shadow-lg p-5"></span><br>
				<label for="phone" class="font-weight-bold mt-3">Phone Number</label>
				<span v-text="user.phone" class="card shadow-lg p-5"></span>
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

	props: ['ads', 'user'],

	data() {
		return {
			filter: new AdFilters({
				sortOrder: 'newFirst',
				indexedCategories: {},
				categories: [],
				filteredFeatured: null,
				filteredNormal: null
			}),
			featuredAds: [],
			normalAds: [],
			filteredAll: [],
			activeCategory: null,
			searchTerm: '',
			timeout: '',
			nothingFound: false
		};
	},

	created() {
		this.populateCollections();
	},

	watch: {
		filteredAll() {
			this.populateCollections();
		}
	},

	computed: {
		adsCount() {
			return this.filteredAll.length != 0 ? this.filteredAll.length : this.ads.length;
		},

		inactiveState() {
			return [this.activeCategory ? '' : 'activeItem font-weight-bold'];
		}
	},

	methods: {
		sortAds() {
			if (this.filter.filteredNormal) {
				this.filter.sortFilter(this.filter.filteredNormal, this.filter.filteredFeatured);
			} else {
				this.filter.sortFilter(this.normalAds, this.featuredAds);
			}
		},

		showInCategory(category) {
			this.activeCategory = category;

			if (this.filteredAll.length != 0) {
				this.populateCollections();

				return this.filter.filterCategory(category, this.filter.filteredNormal, this.filter.filteredFeatured);
			}

			this.filter.filterCategory(category, this.normalAds, this.featuredAds);
		},

		seeAllAds() {
			this.activeCategory = null;

			if (this.filteredAll.length != 0) {
				return this.populateCollections();
			}

			this.reset();
		},

		search() {
			if (this.searchTerm) {
				clearTimeout(this.timeout);
				this.timeout = setTimeout(() => {
					this.reset();
					this.findInCollection(this.ads);
				}, 1000);
			} else {
				this.nothingFound = false;
				this.reset();
				this.populateCollections();

				if (this.filteredAll.length != 0) {
					this.activeCategory = null;
				}

				if (this.activeCategory) {
					this.showInCategory(this.activeCategory);
				}
			}

		},

		findInCollection(collection) {
			for (var i = 0; i < collection.length; i++) {
				if (collection[i].title.toLowerCase().indexOf(this.searchTerm) != -1) {
					this.filteredAll.push(collection[i]);
				}
			}
			this.nothingFound = false;

			if (this.filteredAll.length == 0) {
				this.nothingFound = true;
				this.normalAds = [];
				this.featuredAds = [];
			}
		},

		populateCollections() {
			if (this.filteredAll.length != 0) {
				this.filter.filteredNormal = this.filter.assign(this.filteredAll, false);
				this.filter.filteredFeatured = this.filter.assign(this.filteredAll, true);
				this.filter.groupBy(this.filteredAll);
				this.sortAds();
			} else {
				if (this.nothingFound) return;

				this.featuredAds = this.filter.assign(this.ads, true);
				this.normalAds = this.filter.assign(this.ads, false);
				this.filter.groupBy(this.ads);
				this.sortAds();
			}
		},

		reset() {
			this.filteredAll = [];
			this.filter.filteredNormal = null;
			this.filter.filteredFeatured = null;
		},

		activeState(id) {
			return ['mr-1', this.activeCategory && this.activeCategory.id == id ? 'activeItem font-weight-bold' : ''];
		}
	}
};
</script>

<style>
	.activeItem {
		text-decoration: underline;
		font-size: 17px;
		font-family: 'Consolas';

	}
	.color-box {
		background-color: #fc5132;
	}
	a.activeItem .color-box {
		text-decoration: none;
		background-color: #f7ca4d;
		color: black;
	}
</style>
