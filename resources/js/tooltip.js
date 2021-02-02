import popperTooltip from './PopperTooltip.js';

ads.data.forEach(ad => {
	var button = document.querySelector(`#unique_${ad.slug}`);
	var tooltip = document.querySelector(`#unique_${ad.id}`);

	popperTooltip(button, tooltip);
});

featured.forEach(feature => {
	var button = document.querySelector(`#unique_${feature.slug}`);
	var tooltip = document.querySelector(`#unique_${feature.id}`);

	popperTooltip(button, tooltip);
});
