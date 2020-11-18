<template>
	<div class=" container">
		<div class="row justify-content-center mt-2">
			<figure class="card pt-2 mr-2" v-for="(image, index) in images">
				<div class="img-wrap">
					<img :src="'/storage/' + image.path" alt="image" style="width: 150px; max-height: 150px;">
				</div>
				<figcaption class="info-wrap text-center mt-2 mb-2">
					<button class="btn btn-danger btn-sm" @click="remove(image, index)">Delete</button>
				</figcaption>
			</figure>
		</div>
	</div>
</template>

<script>
	export default {
		props: ['data'],

		data() {
			return {
				images: this.data
			};
		},

		methods: {
			remove(image, index) {
				axios.delete(`/myaccount/images/${image.id}/delete`)
					.then(this.images.splice(index, 1));
			}
		}
	};
</script>
