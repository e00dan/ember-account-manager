// FUNCS
var appPath = 'http://memsoria.pl/m';
var name 	= 'Memsoria 8.6';

var c = {
	getIcon: function (name) {
		return '<i class="' + name + '"></i> ';
	},
	fTime : function (t) {
		var d 	= new Date(t * 1000);
		var yr 	= d.getFullYear();
		var mh	= d.getMonth() + 1;
		var dy	= d.getDate();
		var hs 	= d.getHours();
		var ms 	= d.getMinutes();
		var ss 	= d.getSeconds();
		return yr + '-' + (mh < 10 ? 0 : '') + mh + '-' + (dy < 10 ? 0 : '') + dy + ' ' + (hs < 10 ? 0 : '') + hs + ':' + (ms < 10 ? 0 : '') + ms + ':' + (ss < 10 ? 0 : '') + ss;
	},
	charFor: function (name) {
		return '<a href="#/char/' + name + '">' + name + '</a>';
	},
	navEl: function (name) {
		return '<li><a href="#/v/' + name.toLowerCase() + '">' + name + '</a></li>';
	},
	sDown: function () {
		$("html, body").animate({ scrollTop: $(document).height() + 500 }, 1);
	},
	getNews: function (p) {
		var a = 5;
		var o = (p - 1) * 5;
		var temp = '';
		$.ajaxSetup({async:false});
		$.getJSON ( appPath + '/views/news.php?a=' + a + '&o=' + o, function ( data ) { 
			$.each( data, function () {
				temp 	+= '<h3>' + this['title'] + '</h3>' +
				'<div style="height: 1px; background-color: rgb(194, 194, 194);"></div><br />' +
				'<p>' + this['body'] + '</p>' +
				'<div style="height: 1px; background-color: rgb(194, 194, 194);"></div><br />' +
				'<p class="text-center muted">Written by: <b>' + this['author'] + '</b> | Sent: ' + c.fTime(this['time']) + '</p><br />';
				});
		});
		$.ajaxSetup({async:true});
		pm = (p == 1 ? 1 : parseInt(p) - 1);
		pp = (p == 5 ? 5 : parseInt(p) + 1);
		temp += '<div class="pagination pagination-centered">' +
					'<ul id="pages">' +
						'<li><a href="#/n/' + pm + '">&laquo;</a></li>' +
						'<li><a href="#/n/1">1</a></li>' +
						'<li><a href="#/n/2">2</a></li>' +
						'<li><a href="#/n/3">3</a></li>' +
						'<li><a href="#/n/4">4</a></li>' +
						'<li><a href="#/n/5">5</a></li>' +
						'<li><a href="#/n/' + pp + '">&raquo;</a></li>' +
					'</ul>' +
				'</div>';
		setTimeout(function () {
			$('#main').html(temp);
			$('.pagination ul li a:contains("' + p + '")').parent().addClass('active');
			$('.pagination a').click(function () {
				setTimeout(function () {
					c.sDown();
				}, 10);
			});
		}, 0);
	},
	cat: function (name, els) {
		var temp = '<li class="dropdown">' +
					'<a class="dropdown-toggle" data-toggle="dropdown" href="#">' + name + '<b class="caret"></b></a>' +
						'<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">';
		$.each( els, function () {
			if (this[0] == 'div') {
				temp += '<li class="divider"></li>';
			} else {
				if (this[2] != '//index') {
					var a = '<a href="#/v/' + this[2].toString() + '">';
				} else {
					var a = '<a href="#/">';
				}
				temp += '<li>' + a + c.getIcon(this[1].toString()) + this[0].toString() + '</a></li>';
			}
		});
		
		temp += '</ul>' +
			'</li>';
		return temp;
	},
	getView: function (name) {
		App.View.set('name', name);
		App.View.getContents();
		$('#stats').hide();
	},
	relAcc: function () {
		$('#acc_target').html(App.loadMenu());
	}
}


// INSTANCE
App = Em.Application.create({
	name: name,
	ready: function() {
		$(document).attr('title', name);
		$.get( appPath + '/engine/online_players.php', function (data) {
			$('#online').html('Online: ' + data);
		});
		$(function () {
			$('#toTop').click(function() {
				$('body,html').animate({scrollTop:0},800);
			});
			
			$('.menu-options-white').click(function () {
				localStorage.navClass = 'navbar-default';
				$('.navbar-inverse').removeClass('navbar-inverse').addClass('navbar-default');
			});
			
			$('.menu-options-black').click(function () {
				localStorage.navClass = 'navbar-inverse';
				$('.navbar-default').removeClass('navbar-default').addClass('navbar-inverse');
			});
		});
	},
	loadTopNav: function () {
		if (typeof localStorage.navClass == 'undefined' && localStorage.navClass == null) {
			localStorage.navClass = 'navbar-inverse';
		}
		
		return Em.Handlebars.compile(
		'<div class="navbar navbar-fixed-top ' + localStorage.navClass + '">' +
			'<div class="navbar-inner">' +
				'<div class="container">' +
					'<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">' +
						'<span class="icon-bar"></span>' +
						'<span class="icon-bar"></span>' +
						'<span class="icon-bar"></span>' +
					'</a>' +
					'{{#linkTo \'index\' class="brand"}}{{App.name}}{{/linkTo}}' +
					'<div class="nav-collapse">' +
						'<ul class="nav">' +
							'<li class="divider-vertical"></li>' +
							'<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#" id="acc">Account <b class="caret"></b></a><ul class="dropdown-menu" style="padding: 5px;" id="acc_target">{{view App.Account}}</ul></li>' +
							c.navEl( 'Guilds') +
							c.navEl( 'Shop') +
							c.navEl( 'Forum') +
							c.navEl( 'Highscores' ) +
							'<li><a href="#"><span class="badge badge-inverse" id="online">Online: ?</span></a></li>' +
						'</ul>' +
					'</div>' +
					'<div class="menu-options-white">' +
						'<div class="up"></div>' +
						'<div class="down"></div>' +
					'</div>' +
					'<div class="menu-options-black">' +
						'<div class="up"></div>' +
						'<div class="down"></div>' +
					'</div>' +
				'</div>' +
			'</div>' +
		'</div>'
		)
	},
	
	loadStats: function( action ) {
		$.ajaxSetup({async:false});
		var temp = '';
		$.getJSON( appPath + '/views/stats.php', {}, function ( data ) {
			temp = data;
		});
		$.ajaxSetup({async:true});
		var content = 'Last joined us: ' + c.charFor(temp['last']) + ', player number ' + temp['ammount'] + '. Welcome and wish you a nice game!' +
		'<br />Currently, the best player on the server is: ' + c.charFor(temp['best']) + ' (' + temp['level'] + ' lvl). Congratulations!' +
		'<br />Houses: ' + temp['houses'] + ' & Accounts in database: ' + temp['accounts'] + '.' +
		'<div style="text-align: right;"><button class="btn btn-link" {{action reloadStats}}>' + c.getIcon('icon-refresh') + '</button></div>';
		$('#stats i').addClass('icon-spin');
		if (action) {
			content = Em.Handlebars.compile(content);
			return content;
		} else {
			content = content.replace('{{action reloadStats}}', 'data-ember-action="1" ');
			$('#stats').html(content);
		}
	},
	loadMenu: function () {
		var temp = '';
		$.ajaxSetup({async:false});
		$.get( appPath + '/views/acc_menu.php', function(data) {
			temp = data;
		});
		$.ajaxSetup({async:true});
		return temp;
	}
});

// ROUTES
App.Router.map(function() {
	this.resource('news', { path: '/n/:id' });
	this.resource('view', { path: '/v/:view_name' });
});

App.IndexRoute = Em.Route.extend({
	model: function () {
		c.getNews(1);
		$('.active').removeClass('active');
		$('a[href="#//"]').addClass('active');
	},
	events: {
		reloadStats: function () {
			App.loadStats(false);
		}
	}
});

App.ViewRoute = Em.Route.extend({
	model: function(params) {
		c.getView(params.view_name);
	},
	events: {
		reloadStats: function () {
			App.loadStats(false);
		}
	}
});

App.NewsRoute = Em.Route.extend({
	model: function(params) {
		c.getNews(params.id);
	},
	events: {
		reloadStats: function () {
			App.loadStats(false);
		}
	}
});

// CONTROLLERS
App.View = Em.ArrayController.create({
	name: '',
	getContents: function() {
		$('#main').html(c.getIcon('icon-spinner icon-spin icon-4x'));
		var name = this.get('name');
		if (Em.isEmpty(name)) {
			return;
		}
		var url = appPath + '/views/' + name + '.php';
		$.get(url, function (data) {
			navEl = $('a[href="#/v/' + name + '"]');
			$('.active').removeClass('active');
			if (navEl.class == 'ember-view active') {
			} else {
				navEl.parent().addClass('active');
			}
			$('#main').empty().height('0px').height('100%').html(data + '<div style="text-align: right;"><a href="#/v/' + name + '" onclick="c.getView(\'' + name + '\')" >' + c.getIcon('icon-refresh') + '</a></div>');
		});
	}
});

// VIEWS
App.TopNav = Em.View.create({
	name: 'TopNav',
	template: App.loadTopNav()
});

App.VerNav = Em.View.create({
	name: 'VerNav',
	template: Em.Handlebars.compile(
		'<div class="nav span2" id="VerNav">' +
				'<ul class="nav nav-tabs nav-stacked">' +
					c.cat( 'News', [ [ 'Latest News', 'icon-list-ul', '//index' ], [ 'Archive', 'icon-file', 'archive' ], [ 'Information', 'icon-info-sign', 'information' ], [ 'div' ], [ 'Add', 'icon-plus', 'add_news' ] ] ) +
					c.cat( 'Account', [ [ 'Log in', 'icon-unlock', 'log_in' ], [ 'Create account', 'icon-group', 'create_account' ], [ 'Lost account?', 'icon-key', 'lost_account' ], [ 'div' ], [ 'Manage', 'icon-user', 'acc_manage' ] ] ) +
					c.cat( 'Community', [ [ 'Who is online?', 'icon-bar-chart', 'online' ], [ 'Characters', 'icon-eye-open', 'characters' ], [ 'Support', 'icon-sitemap', 'support' ], [ 'Statistics', 'icon-signal', 'statistics' ] ] ) +
					c.cat( 'Shop', [ [ 'Item Shop', 'icon-shopping-cart', 'shop' ], [ 'Buy Points', 'icon-money', 'buy_points' ], [ 'div' ], [ 'History', 'icon-book', 'shop_history' ] ] ) +
				'</ul>' +
			'</div>'
			)
});

App.Footer = Em.View.create({
	name: 'Footer',
	template: Em.Handlebars.compile(
	'<div class="alert alert-info" style="text-align: center;">' +
	c.getIcon('icon-info-sign') + 'Accmaker by <b><a href="http://tibia.net.pl/members/281422-Kuzirashi">Kuzirashi</a></b>. All rights reserved.' +
	'</div>')
});

App.Stats = Em.View.create({
	name: 'stats',
	template: App.loadStats( true )
});

App.Account = Em.View.create({
	name: 'account',
	template: Em.Handlebars.compile(App.loadMenu())
});

