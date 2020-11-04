<template>
	<div class="d-flex justify-content-between">
		<div class="level">
			<div class="img-wraps">
				<i class="far fa-trash-alt bin" @click="removeImage"></i>
				<img :src="avatar" width="150" height="150" class="mr-2 rounded">
			</div>

			<h3>
				{{ user.name }}
			</h3>
		</div>
		<form v-if="canUpdate" method="POST" enctype="multipart/form-data">
			<input type="file" accept="image/*" @change="onChange"><br>
			<small>Maximum dimensions: 200x200 pixels!</small>
		</form>
	</div>
</template>

<script>
export default {
	props: ['user'],

	data() {
		return {
			avatar: '/storage/' + this.user.avatar
		};
	},

	computed: {
		canUpdate() {
			return this.authorize(user => user.id === this.user.id);
		}
	},

	methods: {
		onChange(e) {
			if (! e.target.files.length) return;

			let file = e.target.files[0];

			let reader = new FileReader();

			reader.readAsDataURL(file);

			reader.onload = e => {
				let path = e.target.result;

				this.persist(file, path);
			}
		},

		persist(file, path) {
			let data = new FormData();

			data.append('image', file);

			if (!window.App.user.confirmed) {
				return flash('You must first confirm your profile!', 'danger');
			}

			axios.post(`/myaccount/settings/${this.user.id}/logos`, data)
				.then(() => {
					this.avatar = path;
					flash('Logo uploaded!');
				}, () => {
					flash('Invalid image dimensions!', 'danger');
				});
		},

		removeImage() {
			axios.delete(`/myaccount/settings/${this.user.id}/logos/delete`)
				.then(this.avatar = 'users/default.png')
				.then(() => flash('Image deleted!'));
		}
	}
};
</script>

<style>
	.img-wraps {
	  position: relative;
	  width: 10%;
	}

	.img-wraps .bin {
	  position: absolute;
	  display: none;
	  top: 50%;
	  left: 400%;
	  transform: translate(-50%, -50%);
	  -ms-transform: translate(-50%, -50%);
	  color: white;
	  font-size: 2em;
	  border: none;
	  cursor: pointer;
	  border-radius: 5px;
	}

	.img-wraps:hover .bin {
		display: block;
	}
</style>
