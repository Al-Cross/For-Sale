<template>
	<div class="dropdown" v-cloak>
		<a href="#" data-toggle="dropdown" aria-label="Show notifications" class="text-black" style="font-size: smaller;">
			<span class="border-left pl-xl-4"></span>
			Notifications
			<i id="bell" :data-count="notifications.length" class="fas icon-red circle"></i>
		</a>
		<ul class="app-notification dropdown-menu dropdown-menu-right">
			<li class="app-notification__title" v-if="notifications.length == 0">
				<p>No new notifications.</p>
			</li>
			<li class="app-notification__title font-weight-bold" v-if="notifications.length > 0">
				<a href="#" class="text-black" @click="markAllAsRead">Mark All As Read</a>
			</li>
			<div class="app-notification__content" v-for="notification in notifications">
				<li>
					<a class="app-notification__item d-flex" :href="notification.data.link" @click="markAsRead(notification)">
						<span class="app-notification__icon">
							<span class="fa-stack fa-lg">
								<i class="fas fa-envelope fa-stack-1x fa-inverse"></i>
							</span>
						</span>
						<div>
							<p class="app-notification__message font-weight-bold" v-text="notification.data.message"></p>
							<p class="app-notification__meta text-xs">{{ time(notification.created_at) }}</p>
						</div>
					</a>
				</li>
			</div>
		</ul>
	</div>
</template>

<script>
var moment = require('moment');

export default {
	data() {
		return { notifications: false }
	},

	created() {
		 axios.get('/myaccount/notifications')
			.then(response => this.notifications = response.data);
	},

	methods: {
		markAsRead(notification) {
			axios.delete(`/myaccount/${notification.id}`);
		},

		markAllAsRead() {
			if (this.notifications.length > 0) {
				axios.delete('/myaccount/mark-all')
				.then(this.notifications = []);
			}
		},

		time(created_at) {
			return 'Received ' + moment(created_at).fromNow();
		}
	}
};
</script>

<style>
	*.icon-blue {color: #0088cc}
	*.icon-red {color: white}
	#bell {
		text-align: center;
		vertical-align: middle;
		position: relative;
	}
	.circle:after{
		content:attr(data-count);
		position: absolute;
		background: red;
		height: 1rem;
		top: -1.5rem;
		width: 1rem;
		text-align: center;
		line-height: 1rem;;
		font-size: 0.5rem;
		border-radius: 50%;
		color:white;
		border:1px;
	}
	.circle[data-count="0"]:after{ display : none; }

	.app-notification {
		opacity: 0.8;
		max-height: 220px;
		min-width: 270px;
		overflow-y: auto;
		border-bottom: dashed;
	}

	.app-notification__title {
	  padding: 8px 20px;
	  text-align: left;
	  background-color: rgba(0, 150, 136, 0.4);
	  color: #333;
	}

	.app-notification__footer {
	  padding: 8px 20px;
	  text-align: center;
	  background-color: #eee;
	}

	.app-notification__content {
	  max-height: 220px;
	}

	.app-notification__content::-webkit-scrollbar {
	  width: 6px;
	}

	.app-notification__content::-webkit-scrollbar-thumb {
	  background: rgba(0, 0, 0, 0.2);
	}

	.app-notification__item {
	  display: -webkit-box;
	  display: -ms-flexbox;
	  display: flex;
	  padding: 8px 20px;
	  color: inherit;
	  border-bottom: 1px solid #ddd;
	  -webkit-transition: background-color 0.3s ease;
	  -o-transition: background-color 0.3s ease;
	  transition: background-color 0.3s ease;
	}

	.app-notification__item:focus, .app-notification__item:hover {
	  color: inherit;
	  text-decoration: none;
	  background-color: #e0e0e0;
	}

	.app-notification__message,
	.app-notification__meta {
	  margin-bottom: 0;
	  font-size: 15px;
	}

	.app-notification__icon {
	  padding-right: 10px;
	}

	.app-notification__message {
	  line-height: 1.2;
	}

	.text-xs {
	  font-size: 12px;
	}
</style>
