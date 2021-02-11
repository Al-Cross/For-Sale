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
			window.scrollTo(0, 300);
		},

		nextPage() {
			this.pageNumber++;
			window.scrollTo(0, 300);
		},

		indexing(page) {
			this.pageNumber = page - 1;
			window.scrollTo(0, 1400);
		},

		onPage(page) {
			return this.pageNumber == page - 1 ? ' bg-light' : '';
		}
	}
};
