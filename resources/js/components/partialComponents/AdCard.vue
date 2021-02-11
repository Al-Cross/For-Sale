<template>
	<div>
		<div class="row">
			<div v-for="(ad, index) in paginatedData" :key="index" class="col-lg-6">
				<div class="d-block d-md-flex listing vertical">
	                <a :href="'/' + ad.section.category.slug + '/' + ad.section.slug + '/' + ad.slug"
	                    class="img d-block"
	                    :style="{ 'background-image': 'url(/storage/' + mainImage(ad.images) + ')' }">
	                </a>
	                <div class="lh-content">
	                    <span class="category">{{ ad.section.category.name }}</span>
	                    <span class="listings-single">€{{ ad.price }}</span>
	                    <favourite v-if="signedIn" :ad="ad" @deleted="reemit(index)" :key="ad.id"></favourite>
	                    <div v-else>
	                    	<a href="/login" :id="'unique_' + ad.slug" class="bookmark"><span class="icon-heart"></span></a>
					    	<span :id="'unique_' + ad.id" role="tooltip">
						    	Log in to observe this ad
								<div id="arrow" data-popper-arrow></div>
						    </span>
	                    </div>
	                    <h3 style="height: 39px;"><a :href="'/' + ad.section.category.slug + '/' + ad.section.slug + '/' + ad.slug">
		                    {{ ad.title }}
		                </a></h3>
	                    <address>{{ ad.city.city }}</address>
	                </div>
	            </div>
			</div>
		</div>
		<div v-if="ads.length > perPage">
			<button :disabled="pageNumber === 0" @click="prevPage" class="btn btn-sm btn-primary rounded">Previous</button>
			<button v-for="index in pageCount"
					@click="indexing(index)"
					:class="'btn btn-sm btn-primary rounded mr-1' + onPage(index)"
					v-text="index"></button>
			<button :disabled="pageNumber >= pageCount - 1" @click="nextPage" class="btn btn-sm btn-primary rounded">Next</button>
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
			perPage: 20,
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
