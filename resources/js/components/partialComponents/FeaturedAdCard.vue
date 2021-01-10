<template>
	<div class="row mt-4">
		<div class="col-12 block-13 mb-5">
			<div class="col-lg-9">
				<div class="d-block d-md-flex listing" v-for="feature in preview">
		            <a :href="'/' + feature.section.category.slug + '/' + feature.section.slug + '/' + feature.slug"
		                class="img d-block"
		                :style="{ 'background-image': 'url(/storage/' + mainImage(feature.images) + ')' }">
		            </a>
		            <span class="badge badge-info rounded">FEATURED</span>
		            <div class="lh-content">
		                <span class="category">{{ feature.section.category.name }}</span><br>
		                <span class="listings-single">€{{ feature.price }}</span>
		                <a href="#" class="bookmark"><span class="icon-heart"></span></a>
		                <h3><a :href="'/' + feature.section.category.slug + '/' + feature.section.slug + '/' + feature.slug">
			                {{ feature.title }}
			            </a></h3>
		                <address>{{ feature.city.city }}</address>
		            </div>
		        </div>

		        <div v-if="seeAll">
		        	<div class="d-block d-md-flex listing" v-for="feature in expanded">
			            <a :href="'/' + feature.section.category.slug + '/' + feature.section.slug + '/' + feature.slug"
			                class="img d-block"
			                :style="{ 'background-image': 'url(/storage/' + mainImage(feature.images) + ')' }">
			            </a>
			            <span class="badge badge-info rounded">FEATURED</span>
			            <div class="lh-content">
			                <span class="category">{{ feature.condition }}</span><br>
			                <span class="listings-single">€{{ feature.price }}</span>
			                <a href="#" class="bookmark"><span class="icon-heart"></span></a>
			                <h3><a :href="'/' + feature.section.category.slug + '/' + feature.section.slug + '/' + feature.slug">
				                {{ feature.title }}
				            </a></h3>
			                <address>{{ feature.city.city }}</address>
			            </div>
			        </div>
		        </div>
		        <button type="button"
		        		v-if="collection.length > 5"
		        		@click="toggleExpansion"
		        		class="btn btn-primary rounded"
		        		v-text="btnText"
		        ></button>
			</div>
	    </div>
	</div>
</template>

<script>
export default {
	props: ['collection'],

	data() {
		return {
			preview: [],
			expanded: [],
			seeAll: false,
			btnText: 'See All'
		};
	},

	created() {
		this.setCollections();
	},

	watch: {
		collection() {
			this.setCollections();
		}
	},

	methods: {
		mainImage(images) {
			return images.length == 0 ? 'images/default-image.jpg' : images[0].path;
		},

		setCollections() {
			this.preview = this.collection.slice(0, 5);
			this.expanded = this.collection.slice(5);
		},

		toggleExpansion() {
			if (! this.seeAll) {
				this.seeAll = true;
				this.btnText = 'See Less';
			} else {
				this.seeAll = false;
				this.btnText = 'See All';
			}
		}
	}
};
</script>
