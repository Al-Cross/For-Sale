class AdFilters {
	constructor(data) {
		Object.assign(this, data);
		this.privateFeatured = this.assign(data.private, true);
		this.businessFeatured = this.assign(data.business, true);
		this.privateAds = this.assign(data.private, false);
		this.businessAds = this.assign(data.business, false);
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

	sortFilter(collection, featuredCollection, sortOrder) {
		if (sortOrder === 'ascending') {
			collection.sort((ad1, ad2) => {
				return ad1.price - ad2.price;
			});

			featuredCollection.sort((feature1, feature2) => {
				return feature1.price - feature2.price;
			});
		} else if (sortOrder === 'descending') {
			collection.sort((ad1, ad2) => {
				return ad2.price - ad1.price;
			});

			featuredCollection.sort((feature1, feature2) => {
				return feature2.price - feature1.price;
			});
		} else {
			collection.sort((ad1, ad2) => {
				return new Date(ad1.created_at) - new Date(ad2.created_at);
			});

			featuredCollection.sort((feature1, feature2) => {
				return new Date(feature1.created_at) - new Date(feature2.created_at);
			});
		}

		if (collection.length == 0 && featuredCollection.length == 0) {
			this.empty = true;
		} else {
			this.empty = false;
		}
	}
}

export default AdFilters;
