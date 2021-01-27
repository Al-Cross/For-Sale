<template>
	<div>
		<div class="dropdown mb-3" id="1">
	    	<button class="btn btn-info dropdown-toggle w-100"
	    			data-toggle="dropdown"
	    			aria-haspopup="true"
	    			aria-expanded="false">Edit Profile</button>
	    	<div class="dropdown-menu w-100 p-4">
	    		<form @submit.prevent="submit('profileForm')">
	        		<div class="form-row">
	        			<div class="col">
	        				<div class="form-group">
			        			<label for="name">Name:</label><br>
			        			<input type="text"
			        					name="name"
			        					v-model="profileForm.name"
			        					:class="profileForm.errors.name ? 'border-danger bg-gray w-75 rounded' : 'bg-gray border w-75 rounded'"
			        					@focus="empty('name')"
			        					required>
			        			<small class="text-danger" v-if="profileForm.errors.name" v-text="profileForm.errors.name[0]"></small>
			        		</div>
			        		<div class="form-group">
			        			<label for="email">Email Address:</label><br>
			        			<input type="email"
			        					name="email"
			        					@focus="empty('email')"
			        					v-model="profileForm.email"
			        					:class="profileForm.errors.email ? 'border-danger bg-gray w-75 rounded' : 'bg-gray border w-75 rounded'">
			        			<small class="text-danger" v-if="profileForm.errors.email" v-text="profileForm.errors.email[0]"></small>
			        		</div>
			        		<div class="form-group">
			        			<label for="address">Address:</label><br>
			        			<input type="text"
			        					name="address"
			        					@focus="empty('address')"
			        					v-model="profileForm.address"
			        					:class="profileForm.errors.address ? 'border-danger bg-gray w-75 rounded' : 'bg-gray border w-75 rounded'">
			        			<small class="text-danger" v-if="profileForm.errors.address" v-text="profileForm.errors.address[0]"></small>
			        		</div>
			        		<div class="form-group">
			        			<label for="phone">Phone Number:</label><br>
			        			<input type="text"
			        					name="phone"
			        					@focus="empty('phone')"
			        					v-model="profileForm.phone"
			        					:class="profileForm.errors.phone ? 'border-danger bg-gray w-75 rounded' : 'bg-gray border w-75 rounded'">
			        			<small class="text-danger" v-if="profileForm.errors.phone" v-text="profileForm.errors.phone[0]"></small>
			        		</div>
	        			</div>
		        		<div class="col">
		        			<div class="form-group">
			        			<label for="about">About Me:</label><br>
			        			<textarea name="about"
			        					rows="8"
			        					@focus="empty('about')"
			        					v-model="profileForm.about"
			        					:class="profileForm.errors.about ? 'border-danger bg-gray w-100 rounded' : 'bg-gray border w-100 rounded'"></textarea>
			        			<small class="text-danger" v-if="profileForm.errors.about" v-text="profileForm.errors.about[0]"></small>
			        		</div>
		        		</div>
	        		</div>
	        		<button class="btn btn-primary rounded">Edit</button>
	        	</form>
	    	</div>
	    </div>

	    <div class="dropdown mb-3" id="2">
	    	<button class="btn btn-info dropdown-toggle w-100"
	    			data-toggle="dropdown"
	    			aria-haspopup="true"
	    			aria-expanded="false">Change Password</button>
	    	<div class="dropdown-menu w-100 p-4">
	    		<form @submit.prevent="submit('passwordForm')">
	        		<div class="form-group">
	        			<label for="current_password">Current Password:</label><br>
	        			<input type="password"
	        					name="old_pass"
	        					v-model="passwordForm.old_pass"
	        					@focus="clear('old_pass')"
	        					:class="passwordForm.errors.old_pass ? 'border-danger bg-gray w-50 rounded' : 'bg-gray border w-50 rounded'"
	        					autocomplete="old_pass">
	        			<small class="text-danger" v-if="passwordForm.errors.old_pass" v-text="passwordForm.errors.old_pass"></small>
	        		</div>
	        		<div class="form-group">
	        			<label for="new-password">New Password:</label><br>
	        			<input type="password"
	        					name="password"
	        					v-model="passwordForm.password"
	        					:class="passwordForm.errors.password ? 'border-danger bg-gray w-50 rounded' : 'bg-gray border w-50 rounded'"
	        					autocomplete="password">
	        			<small class="text-danger" v-if="passwordForm.errors.password" v-text="passwordForm.errors.password[0]"></small>
	        		</div>
	        		<button type="submit" class="btn btn-primary rounded">Change Password</button>
	        	</form>
	    	</div>
	    </div>

	    <div class="dropdown mb-3" id="3">
	    	<button class="btn btn-info dropdown-toggle w-100"
	    			data-toggle="dropdown"
	    			aria-haspopup="true"
	    			aria-expanded="false">Notifications</button>
	    	<div class="dropdown-menu w-100 p-4">
	    		<form @submit.prevent="submit('checkbox')">
	    			<div class="row">
	    				<div class="col">
	    					<div class="form-group">
		    					<label for="new-message" class="mr-custom">New Messages</label>
			    				<small>Notifications by email about new messages on your ads</small><br>
			        			<small class="text-danger" v-if="checkbox.errors.newMessage" v-text="checkbox.errors.newMessage[0]"></small>
			    			</div>
	    				</div>
	    				<div class="col">
		    				<input type="checkbox" name="notifications" v-model="checkbox.newMessage">
	    				</div>
	    			</div>
	    			<div class="row">
	    				<div class="col">
	    					<div class="form-group">
		    					<label for="lower-price" class="mr-custom">Lower Prices</label>
			    				<small>Notifications by email about lowered prices on observed ads.</small><br>
			        			<small class="text-danger" v-if="checkbox.errors.loweredPrice" v-text="checkbox.errors.loweredPrice[0]"></small>
			    			</div>
	    				</div>
	    				<div class="col">
							<input type="checkbox" name="notifications" v-model="checkbox.loweredPrice">
	    				</div>
	    			</div>
	    			<button type="submit" class="btn btn-primary rounded">Save</button>
	    		</form>
	    	</div>
	    </div>

	    <div class="dropdown mb-3" id="4">
	    	<button class="btn btn-info dropdown-toggle w-100"
	    			data-toggle="dropdown"
	    			aria-haspopup="true"
	    			aria-expanded="false">Logo</button>
	    	<div class="dropdown-menu w-100 p-4">
	    		<logo-form :user="user"></logo-form>
	    	</div>
	    </div>

	    <div class="dropdown mb-3" id="5">
	    	<button class="btn btn-info dropdown-toggle w-100"
	    			data-toggle="dropdown"
	    			aria-haspopup="true"
	    			aria-expanded="false">Profile Actions</button>
	    	<div class="dropdown-menu w-100 p-4">
	    		<h4>Profile Removal</h4>
	    		<p>The removal of your profile is an irreversible action that deletes all of its associated data.</p>
	    		<form @submit.prevent="submit('deleteProfile')">
	    			<a href="#" class="btn btn-warning" @click.prevent="$modal.show('deletion-email')">Delete Profile</a>
	    			<modal name="deletion-email" classes="p-4 rounded-lg" height="auto" :focusTrap="true" :shiftX="0.3" :shiftY="0.2">
	    				<h6 class="d-flex justify-content-center">Deletion of your profile must be confirmed via email.</h6><br>
	    				<div class="d-flex justify-content-center">
	    					<button type="button" class="btn btn-info rounded mr-3" @click="$modal.hide('deletion-email')">Cancel</button>
		    				<button type="submit" class="btn border-custom">Send Email</button>
	    				</div>
	    			</modal>
	    		</form>
	    	</div>
	    </div>
	</div>
</template>

<script>
import FormHandling from '../FormHandling.js';
import LogoForm from './LogoForm';

export default {
	props: ['user'],

	data() {
		return {
			profileForm: new FormHandling({
				name: this.user.name,
				email: this.user.email,
				address: this.user.address,
				phone: this.user.phone,
				about: this.user.about,
				endpoint: '/myaccount/settings/update'
			}),
			passwordForm: new FormHandling({
				old_pass: '',
				password: '',
				endpoint: '/myaccount/settings/pass'
			}),
			checkbox: new FormHandling({
				newMessage: this.user.notification_settings.new_message,
				loweredPrice: this.user.notification_settings.lowered_price,
				endpoint: '/myaccount/settings/notifications'
			}),
			deleteProfile: new FormHandling({
				user_id: this.user.id,
				endpoint: '/myaccount/settings/deletion-email'
			})
		};
	},

	methods: {
		submit(formType) {
			if (formType != 'deleteProfile') {
				var response = this[formType].patch(this[formType].endpoint);

				response.catch((error) => {
					flash('Oops, something went wrong! Try again!', 'danger');
				})
				.then((message) => {
					flash(message[0]);
				});
			} else if (formType == 'deleteProfile') {
				this[formType].post(this[formType].endpoint);

				window.location.href = '/myaccount/settings/email-sent';
			}
		},

		empty(fieldName) {
			this.profileForm[fieldName] = '';
		},

		clear(fieldName) {
			this.passwordForm.errors[fieldName] = false;
		}
	}
};
</script>

<style>
	.dropdown.show {
		padding-bottom: 300px;
	}

	.bg-gray {
		background: #f2f4f5;
	}

	.mr-custom {
		margin-right: 350px;
	}

	.border-custom {
		transition: border-bottom 1s;
	}
	.border-custom:hover {
		border-bottom: double;
	}
</style>
