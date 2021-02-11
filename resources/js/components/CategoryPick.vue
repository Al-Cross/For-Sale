<template>
	<div>
		<modal name="category-pick" classes="p-2 rounded-lg" height="auto">
		 	<span class="font-weight-bold mr-5">Categories</span>
		 	<span class="font-weight-bold ml-5">Sections</span>
		 	<hr>
		 	<div class="container">
		 		<div class="row">
		 			<div class="col-md-5">
				        <button v-for="category in categories"
				        		class="btn btn-light btn-lg border-bottom btn-size"
				        		v-text="category.name"
				        		@click.prevent="selected(category)"></button>
				 	</div>
				 	<div class="col-md-5">
				 		<button v-for="section in sections"
				 				class="btn btn-light border-bottom btn-size"
				 				v-text="section.name"
				 				@click.prevent="pick(section) & $modal.hide('category-pick')"></button>
				 	</div>
		 		</div>
		 	</div>
	    </modal>
	    <span class="text-primary" v-text="category"></span>
	    <span class="text-primary" v-text="section"></span>
	    <input type="text" class="" id="section_id" name="section_id" v-model="section_id" required>
	</div>
</template>

<script>
	export default {
		props: ['categories'],

		data() {
			return {
				sections: [],
				section: '',
				section_id: '',
				category: ''
			};
		},

		methods: {
			selected(category) {
				this.sections = category.sections;
				this.category = category.name + ' >';
			},

			pick(section) {
				this.section = section.name;
				this.section_id = section.id;
			}
		}
	};
</script>

<style>
	.btn-size { width: 200px !important; }
	#section_id { opacity: 0; }
</style>
