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
import { createPopper } from '@popperjs/core';

export default {
	props: ['ad'],

	data() {
		return {
			active: this.ad.isBeingObserved,
			title: this.generateString()
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

		let popperInstance = null;

	    function create() {
	        popperInstance = createPopper(button, tooltip, {
	          modifiers: [
	            {
	              name: 'offset',
	              options: {
	                offset: [0, 8],
	              },
	            },
	          ],
	        });
	    }

	    function destroy() {
	        if (popperInstance) {
	          popperInstance.destroy();
	          popperInstance = null;
	        }
	    }

	    function show() {
	        tooltip.setAttribute('data-show', '');
	        create();
	    }

	    function hide() {
	        tooltip.removeAttribute('data-show');
	        destroy();
	    }

	    const showEvents = ['mouseenter', 'focus'];
	    const hideEvents = ['mouseleave', 'blur'];

	    showEvents.forEach(event => {
	        button.addEventListener(event, show);
	    });

	    hideEvents.forEach(event => {
	        button.addEventListener(event, hide);
	      });
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
		},

		generateString() {
			// Adding +1 to Math.random() prevents the rare case where the expression in concat() returns an empty string
			return 'unique_' + this.ad.title.replace(/[ ]+/g, '').concat((Math.random() + 1).toString(36).substring(7));
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
	span[id^='unique_'] {
		display: none;
        background: #333;
        color: white;
        font-weight: bold;
        padding: 4px 8px;
        font-size: 13px;
        border-radius: 4px;
        z-index: 1000;
    }
    span[id^='unique_'][data-show] {
	  display: block;
	}
    #arrow,
	#arrow::before {
	  position: absolute;
	  width: 8px;
	  height: 8px;
	  z-index: -1;
	}
	#arrow::before {
	  content: '';
	  transform: rotate(45deg);
	  background: #333;
	}
	span[id^='unique_'][data-popper-placement^='top'] > #arrow {
	  bottom: -4px;
	}

	span[id^='unique_'][data-popper-placement^='bottom'] > #arrow {
	  top: -4px;
	}

	span[id^='unique_'][data-popper-placement^='left'] > #arrow {
	  right: -4px;
	}

	span[id^='unique_'][data-popper-placement^='right'] > #arrow {
	  left: -4px;
	}
</style>
