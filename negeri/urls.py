from django.conf.urls import patterns, url

from negeri import views

urlpatterns = patterns('',
    url(r'^$', views.index, name='index')
)