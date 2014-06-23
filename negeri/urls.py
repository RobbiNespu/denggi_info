from django.conf.urls import patterns, url

from negeri import views

urlpatterns = patterns('negeri.views',
#    url(r'^$', views.index, name='index')
	url(r'^(?P<keyword>[a-zA-Z0-9\s\+]+)$', 'index', name='index')
)