<template>
	<div>
		<ul role="tablist" class="nav nav-tabs" @keydown="switchTabs">
			<li v-for="tab in tabs" class="nav-item">
				<a :href="tab.href"
					role="tab"
					class="nav-link"
					:aria-selected="tab.isActive"
			        :aria-controls="'tabpanel-' + tab.id"
					:tabindex="tab.isActive ? '-1' : '0'"
					:class="{ 'active background shadow': tab.isActive }"
					@click="selectTab(tab)">{{ tab.name }}</a>
			</li>
		</ul>

		<div class="tabs-details">
			<slot></slot>
		</div>
	</div>
</template>

<script>
import Tab from './Tab';

export default {
	components: { Tab },

	data() {
		return {
			tabs: [],
			keys: {
			    end: 35,
			    home: 36,
			    left: 37,
			    right: 39
			},
			currentIndex: null
		};
	},

	created() {
		this.tabs = this.$children;
	},

	mounted() {
		this.tabs.forEach((tab, index) => {
			window.localStorage.setItem('activeTab', window.location.hash);
			let activeTab = window.localStorage.getItem('activeTab');
			if (activeTab) {
				tab.isActive = (tab.href.includes(activeTab));
				window.localStorage.removeItem('activeTab');
			}

			if (tab.isActive) {
				this.$emit('active', tab.name, false);

				return this.currentIndex = index;
			}
		});
	},

	methods: {
		selectTab(selectedTab) {
			this.tabs.forEach(tab => {
				tab.isActive = (tab.name == selectedTab.name);
			});

			this.$emit('active', selectedTab.name, true);
		},

		switchTabs(event) {
			var key = event.keyCode;

		    switch (key) {
		    	case this.keys.right:
		    		const rightIndex = this.currentIndex + 1;
		    		if (rightIndex >= this.tabs.length) return;
		    		this.currentIndex = rightIndex;
		    		this.selectTab(this.tabs[this.currentIndex]);
		    		break;
		    	case this.keys.end:
			        event.preventDefault();
			        // Activate last tab
			        this.tabs.forEach(tab => {
						tab.isActive = (tab.name == this.tabs[this.tabs.length - 1].name);
					});
			        break;
			    case this.keys.left:
				    const leftIndex = this.currentIndex - 1;
				    if (leftIndex < 0) return;
				    this.currentIndex = leftIndex;
				    this.selectTab(this.tabs[this.currentIndex]);
				    break;
		    	case this.keys.home:
			        event.preventDefault();
			        // Activate first tab
			        this.tabs.forEach(tab => {
						tab.isActive = (tab.name == this.tabs[0].name);
					});
		    }
		}
	}
};
</script>

<style>
	.background {
		background-color: rgb(177, 225, 225) !important;
	}
</style>
