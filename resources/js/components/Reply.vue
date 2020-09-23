<template>
		<div>
			<button v-if="toggleForm !== true" class="btn btn-primary rounded" @click="toggle">Reply</button>
			<div v-if="toggleForm">
				<textarea rows="5"
						cols="100"
						:placeholder="'Your reply to ' + messageCreator"
						v-model="reply"
						class="rounded-lg ml-3">
				</textarea>
				<div class="card-header">
					<button class="btn btn-danger btn-sm rounded mr-2" @click="sendReply">Send</button>
					<a href="#" @click="toggle">Cancel</a>
				</div>
			</div>
		</div>
</template>

<script>
export default {
	props: ['parentmessage'],

	data() {
		return {
			reply: '',
			toggleForm: false,
			creator: ''
		};
	},

	computed: {
		messageCreator() {
			if (this.parentmessage.creator) {
				return this.parentmessage.creator.name;
			}

			return this.parentmessage.recipient.name;
		}
	},

	methods: {
		toggle() {
			if (this.toggleForm == true) {
				this.toggleForm = false;
			} else {
				this.toggleForm = true;
			}
		},

		sendReply() {
			axios.post('/myaccount/messages/send', {
				ad_id: this.parentmessage.ad_id,
				parent_message_id: this.parentmessage.id,
				recipient_id: this.parentmessage.creator_id,
				subject: this.parentmessage.subject,
				body: this.reply
			})
			.catch(error => {
				flash(error.response.data);
			})
			.then(({data}) => {
				this.reply = '';
				this.toggleForm = false;
				flash('Your reply was sent!');
			});
		}
	}
};
</script>
