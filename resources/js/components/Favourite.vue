<template>
	<div>
		<button type="submit" :class="classes" @click="toggle" :id="'unique' + ad.id">
	        <span class="fas fa-heart"></span>
	    </button>
	    <span :id="title" role="tooltip">
	    	{{ text }}
			<div id="arrow" data-popper-arrow></div>
		</span>
	</div>
</template>

<script>
import popperTooltip from '../PopperTooltip';

export default {
	props: ['ad'],

	data() {
		return {
			active: this.ad.isBeingObserved,
			title: 'unique_' + this.ad.slug
		};
	},

	computed: {
		classes() {
			return ['btn', this.active ? 'btn-sm filled' : 'btn-sm bookmark'];
		},

		text() {
			return this.active ? 'Remove from your favourites' : 'Observe this ad';
		}
	},

	mounted() {
		var title = this.title;
		var button = document.querySelector(`#unique${this.ad.id}`);
		var tooltip = document.querySelector(`#${title}`);

		popperTooltip(button, tooltip);
	},

	methods: {
		toggle() {
			this.active ? this.destroy() : this.create();
		},

		create() {
			axios.post('/favourite', { ad_id: this.ad.id })
				.then(flash('This ad is now being observed.'));

			this.active = true;
		},

		destroy() {
			axios.delete('/unfavourite', { data: { ad_id: this.ad.id, withCredentials: true } })
				.then(flash('The selected ad is no longer observed.'));

			this.active = false;

			this.$emit('deleted');
		}
	}
};
</script>

<style>
	.filled {
		position: absolute;
		top: 20px;
	    right: 20px;
	    width: 30px;
	    height: 30px;
	    border-radius: 50%;
	    display: inline-block;
	    background: rgba(255, 255, 255, 0.3);
	    -webkit-transition: .3s all ease;
	    -o-transition: .3s all ease;
	    transition: .3s all ease;
		background: #f23a2e;
		font-size: 16px;
	}
</style>
