class FormHandling {
	constructor(data) {
		this.originalData = JSON.parse(JSON.stringify(data)); // Deep merge of the data. Removing reactivity.

		Object.assign(this, data);

		this.errors = {};
		this.submitted = false;
	}

	data() {
		let data = {};

		for (let attribute in this.originalData) {
			data[attribute] = this[attribute];
		}

		return data;
	}

	post(endpoint) {
		this.submit(endpoint);
	}

	patch(endpoint) {
		return this.submit(endpoint, 'patch');
	}

	delete(endpoint) {
		this.submit(endpoint, 'delete');
	}

	submit(endpoint, requestType = 'post') {
		return axios[requestType](endpoint, this.data())
				.catch(this.onFail.bind(this))
				.then(this.onSuccess.bind(this));
	}

	onSuccess(response) {
		this.submitted = true;
		this.errors = {}; // Flush the errors

		this.reset();

		return response.data;
	}

	onFail(error) {
		this.errors = error.response.data.errors;
		this.submitted = false;

		throw error;
	}

	reset() { // Clears the form
		Object.assign(this, {});
	}
}

export default FormHandling;
