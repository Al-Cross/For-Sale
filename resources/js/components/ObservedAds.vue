<template>
	<div>
		<featured-ad-card :ads="featuredAds" @deleted="removeFromFeatured"></featured-ad-card>

		 <div class="row">
			<div class="col-lg-8">
				<ad-card :ads="normalAds" @deleted="removeFromNormal"></ad-card>
			</div>
		</div>
        <h3 v-if="normalAds.length == 0 && featuredAds.length == 0" class="font-weight-bold text-center">Nothing to observe</h3>
	</div>
</template>

<script>
import AdCard from './partialComponents/AdCard';
import FeaturedAdCard from './partialComponents/FeaturedAdCard';

export default {
	components: { AdCard, FeaturedAdCard },

	data() {
		return {
			observed: [],
			normalAds: [],
			featuredAds: [],
		};
	},

	created() {
		this.fetch();
	},

	methods: {
		fetch() {
			axios.get('/observed')
				.then(this.refresh);
		},

		refresh({data}) {
			for (var prop in data) {
				this.observed.push(data[prop].ad);
			}

			this.featuredAds = this.observed.filter((ad) => {
				return ad.featured == true;
			});

			this.normalAds = this.observed.filter((ad) => {
				return ad.featured == false;
			});
		},

		removeFromNormal(index) {
			this.normalAds.splice(index, 1);

			flash('The selected ad is no longer observed.');
		},

		removeFromFeatured(index) {
			this.featuredAds.splice(index, 1);

			flash('The selected ad is no longer observed.');
		}
	}
};
</script>
