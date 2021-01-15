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
	                    <favourite :ad="ad" @deleted="reemit(index)" :key="ad.id"></favourite>
	                    <h3><a :href="'/' + ad.section.category.slug + '/' + ad.section.slug + '/' + ad.slug">
		                    {{ ad.title }}
		                </a></h3>
	                    <address>{{ ad.city.city }}</address>
	                </div>
	            </div>
			</div>
			<div v-if="ads.length > perPage">
				<button :disabled="pageNumber === 0" @click="prevPage" class="btn btn-sm btn-primary rounded">Previous</button>
				<button v-for="index in pageCount" @click="indexing(index)" class="btn btn-sm btn-primary rounded mr-1" v-text="index"></button>
				<button :disabled="pageNumber >= pageCount - 1" @click="nextPage" class="btn btn-sm btn-primary rounded">Next</button>
			</div>
		</div>
	</div>
</template>

<script>
import pagination from '../../mixins/pagination';

export default {
	props: ['ads'],

	mixins: [pagination],

	data() {
		return { perPage: 20 };
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
