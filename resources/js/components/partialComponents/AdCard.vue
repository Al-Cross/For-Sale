<template>
	<div class="row">
		<div class="col-lg-6" v-for="ad in ads">
			<div class="d-block d-md-flex listing vertical">
                <a :href="'/' + ad.section.category.slug + '/' + ad.section.slug + '/' + ad.slug"
                    class="img d-block"
                    :style="{ 'background-image': 'url(/storage/' + mainImage(ad.images) + ')' }">
                </a>
                <div class="lh-content">
                    <span class="category">{{ ad.section.category.name }}</span>
                    <span class="listings-single">€{{ ad.price }}</span>
                    <a href="#" class="bookmark"><span class="icon-heart"></span></a>
                    <h3><a :href="'/' + ad.section.category.slug + '/' + ad.section.slug + '/' + ad.slug">
	                    {{ ad.title }}
	                </a></h3>
                    <address>{{ ad.city.city }}</address>
                </div>
            </div>
		</div>
	</div>
</template>

<script>
export default {
	props: ['ads'],

	methods: {
		mainImage(images) {
			return images.length == 0 ? 'images/default-image.jpg' : images[0].path;
		}
	}
};
</script>
