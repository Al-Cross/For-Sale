class AdFilters {
	constructor(data) {
		if (data.private) {
			Object.assign(this, data);
			this.privateFeatured = this.assign(data.private, true);
			this.businessFeatured = this.assign(data.business, true);
			this.privateAds = this.assign(data.private, false);
			this.businessAds = this.assign(data.business, false);
		} else {
			Object.assign(this, data);
		}
	}

	assign(originalCollection, filter) {
		return Object.values(originalCollection).filter((ad) => {
			return ad.featured == filter;
		});
	}

	priceFilter(collection, featuredCollection, inputValue, operator) {
		this[this.collections.filteredAds] = collection.filter((ad) => {
			return operator(parseFloat(ad.price), parseFloat(inputValue));
		});

		this[this.collections.filteredFeatured] = featuredCollection.filter((feature) => {
			return operator(parseFloat(feature.price), parseFloat(inputValue));
		});
	}

	groupBy(values) {
		for (var attribute in this.indexedCategories) delete this.indexedCategories[attribute];
		this.categories = [];

		values.forEach(ad => {
				if (!this.indexedCategories[ad.section.category.id]) {
					this.indexedCategories[ad.section.category.id] = {
						id: ad.section.category.id,
						name: ad.section.category.name,
						ads: []
					};
					this.categories.push(this.indexedCategories[ad.section.category.id]);
				}

				this.indexedCategories[ad.section.category.id].ads.push(ad);
			});
	}

	sortFilter(collection, featuredCollection) {
		if (this.sortOrder === 'ascending') {
			collection.sort((ad1, ad2) => {
				return ad1.price - ad2.price;
			});

			featuredCollection.sort((feature1, feature2) => {
				return feature1.price - feature2.price;
			});
		} else if (this.sortOrder === 'descending') {
			collection.sort((ad1, ad2) => {
				return ad2.price - ad1.price;
			});

			featuredCollection.sort((feature1, feature2) => {
				return feature2.price - feature1.price;
			});
		} else {
			collection.sort((ad1, ad2) => {
				return ad1.created_at > ad2.created_at ? -1 : ad1.created_at < ad2.created_at ? 1 : 0;
			});
			featuredCollection.sort((feature1, feature2) => {
				return feature1.created_at > feature2.created_at ? -1 : feature1.created_at < feature2.created_at ? 1 : 0;
			});
		}

		if (collection.length == 0 && featuredCollection.length == 0) {
			this.empty = true;
		} else {
			this.empty = false;
		}
	}

	filterCategory(category, normalCollection, featuredCollection) {
			this.filteredNormal = normalCollection.filter(ad => {
				return ad.section.category.id == category.id;
			});

			this.filteredFeatured = featuredCollection.filter(feature => {
				return feature.section.category.id == category.id;
			});
	}
}

export default AdFilters;
