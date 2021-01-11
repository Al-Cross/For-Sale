export default {
	data() {
		return {
			pageNumber: 0
		};
	},

	computed: {
		pageCount() {
			let size = this.ads.length, perPage = this.perPage;

			return Math.ceil(size / perPage);
		},

		paginatedData() {
			const start = this.pageNumber * this.perPage;
			const end = start + this.perPage;

			return this.ads.slice(start, end);
		}
	},

	methods: {
		prevPage() {
			this.pageNumber--;
		},

		nextPage() {
			this.pageNumber++;
		}
	}
};
