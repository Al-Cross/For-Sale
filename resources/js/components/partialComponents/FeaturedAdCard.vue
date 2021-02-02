<template>
	<div class="row mt-4">
		<div class="col-12 mb-5">
			<div class="col-lg-9">
	        	<div class="d-block d-md-flex listing" v-for="(feature, index) in paginatedData">
		            <a :href="'/' + feature.section.category.slug + '/' + feature.section.slug + '/' + feature.slug"
		                class="img d-block"
		                :style="{ 'background-image': 'url(/storage/' + mainImage(feature.images) + ')' }">
		            </a>
		            <span class="badge badge-info rounded">FEATURED</span>
		            <div class="lh-content">
		                <span class="category">{{ feature.section.category.name }}</span><br>
		                <span class="listings-single">€{{ feature.price }}</span>
	                    <favourite v-if="signedIn" :ad="feature" @deleted="reemit(index)" :key="feature.id"></favourite>
	                     <div v-else>
	                    	<a href="/login" :id="'unique_' + feature.slug" class="bookmark"><span class="icon-heart"></span></a>
					    	<span :id="'unique_' + feature.id" role="tooltip">
						    	Log in to observe this ad
								<div id="arrow" data-popper-arrow></div>
						    </span>
	                    </div>
		                <h3><a :href="'/' + feature.section.category.slug + '/' + feature.section.slug + '/' + feature.slug">
			                {{ feature.title }}
			            </a></h3>
		                <address>{{ feature.city.city }}</address>
		            </div>
		        </div>
			</div>
			<div v-if="ads.length > perPage">
				<button :disabled="pageNumber === 0" @click="prevPage" class="btn btn-sm btn-primary rounded">Previous</button>
				<button :disabled="pageNumber >= pageCount - 1" @click="nextPage" class="btn btn-sm btn-primary rounded">Next</button>
			</div>
	    </div>
	</div>
</template>

<script>
import pagination from '../../mixins/pagination';
import popperTooltip from '../../PopperTooltip';

export default {
	props: ['ads'],

	mixins: [pagination],

	data() {
		return {
			perPage: 5,
			signedIn: window.App.signedIn
		};
	},

	mounted() {
		this.paginatedData.forEach(ad => {
			var button = document.querySelector(`#unique_${ad.slug}`);
			var tooltip = document.querySelector(`#unique_${ad.id}`);

			popperTooltip(button, tooltip);
		});
	},

	watch: {
		ads() {
			this.pageNumber = 0;
		}
	},

	methods: {
		mainImage(images) {
			return images.length == 0 ? 'images/default-image.jpg' : images[0].path;
		},

		reemit(index) {
			this.$emit('deleted', index);
		}
	}
};
</script>
