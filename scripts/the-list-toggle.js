jQuery.noConflict()

// uses the 'published_posts' and 'all_tags' vars set using wp_localize_script in functions.php

jQuery(document).ready(function() {

	published_posts.forEach(post => {post.date = new Date(post.post_date)});
	display(byDate);

	(function($) {
	    $('.the-list-toggle > a').on('click', function() {
			jQuery('.the-list-toggle').children().removeClass('current-option');
		    var option = jQuery(this);
		    option.addClass('current-option');

		    if (this.text == 'View All Tags') {
		    	display(tags, show_count=false);
		    } else if (this.text == 'By Date') {
		    	display(byDate);
		    } else {
		    	display(byAuthor);
		    }
		});
    })(jQuery);
});

function display(by, show_count=true) {
	jQuery('.the-list').remove();
	jQuery('.the-list-container').append(
		`<div class="the-list">${by()}</div>`
	);
	
	if (show_count) {
		jQuery('.the-list').append(`<br><br>Total number of entries: ${published_posts.length}`);
	};
}

function byAuthor() {
	var result = '';
	var AZ = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'.split('');
	AZ.forEach(letter => {
		var filter = function(post) { 
			return post.author_last_name[0].toUpperCase() == letter
		};

		result += formatGroupList('author', letter, filter);
	});
	return result;
}

function byDate() {
	var result = '';
	// Sort newest first
	published_posts.sort((a,b) => {
		return b.date - a.date;
	});

	var groups = published_posts.map(post => {
		return formatDate(post, showDay=false)
	}).filter(distinct);

	groups.forEach(month => {
		var filter = function(post) {
			return formatDate(post, showDay=false) == month
		};

		result += formatGroupList('date', month, filter);
	});
	return result;
}

function formatGroupList(type, group, filter) {
	var groupResult = '';
	var posts = published_posts.filter(filter);

	if (posts.length > 0) {
		groupResult += `<h2>${group}</h2><br>`;

		if (type == 'date') {
			posts.sort((a,b) => {
				return sortDate(b,a) || sortAuthor(a,b) || sortTitle(a,b);
			});
		} else {
			posts.sort((a,b) => {
				return sortAuthor(a,b) || sortDate(a,b) || sortTitle(a,b);
			})
		};

		posts.forEach(post => {
			groupResult +=
				`${post.parsed_author}<br>
				 ${formatDate(post)}<br>
				 <a class="the-list-title" href="${post.url}">${post.post_title}</a><br>
				 <span class="the-list-category">
				 <a class="slash" href="${post.category_url}">${post.category_name}</a>
				 </span><br><br>
				`;
		})
	}
	return groupResult;
}

function sortAuthor(a,b) {
	return a.author_last_name.toLowerCase().localeCompare(b.author_last_name.toLowerCase());
}

function sortDate(a,b) {
	return a.post_date.split(' ')[0].localeCompare(b.post_date.split(' ')[0]);
}

function sortTitle(a,b) {
	return a.post_title.toLowerCase().localeCompare(b.post_title.toLowerCase());
}

function formatDate(post, showDay=true) {
	var month = post.date.toLocaleString('default', { month: 'long' });
	var day = post.date.getDate();
	var year = post.date.getFullYear();
	if (showDay == true) {
		return `${month} ${day}, ${year}`;
	} else {
		return `${month} ${year}`;
	}
}

function distinct(value, index, self) { 
    return self.indexOf(value) === index;
}

function tags() {
	var result = '<p class="entry-tags category">';
	all_tags.forEach(tag => {
		result += `<span><a href="/tag/${tag['name']}">${tag['name']}</a></span>   `;
	});
	
	result += '</p>';
	return result;
}
