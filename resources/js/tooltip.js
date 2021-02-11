import popperTooltip from './PopperTooltip.js';

if (typeof ads !== 'undefined') {
	ads.data.forEach(ad => {
		let button = document.querySelector(`#unique_${ad.slug}`);
		let tooltip = document.querySelector(`#unique_${ad.id}`);

		popperTooltip(button, tooltip);
	});

	featured.forEach(feature => {
		let button = document.querySelector(`#unique_${feature.slug}`);
		let tooltip = document.querySelector(`#unique_${feature.id}`);

		return popperTooltip(button, tooltip);
	});
} else {
	popperTooltip(button, tooltip);
}
