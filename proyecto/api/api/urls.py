"""api URL Configuration

The `urlpatterns` list routes URLs to views. For more information please see:
    https://docs.djangoproject.com/en/1.8/topics/http/urls/
Examples:
Function views
    1. Add an import:  from my_app import views
    2. Add a URL to urlpatterns:  url(r'^$', views.home, name='home')
Class-based views
    1. Add an import:  from other_app.views import Home
    2. Add a URL to urlpatterns:  url(r'^$', Home.as_view(), name='home')
Including another URLconf
    1. Add an import:  from blog import urls as blog_urls
    2. Add a URL to urlpatterns:  url(r'^blog/', include(blog_urls))
"""
from django.conf.urls import patterns, url, include
from rest_framework.urlpatterns import format_suffix_patterns
from app import views
#from django.contrib import admin

urlpatterns = [
    url(r'^cliente/$', views.ClienteList.as_view()),
    url(r'^cliente/(?P<pk>[0-9]+)$', views.ClienteDetail.as_view()),
    url(r'^entrega/$', views.EntregaList.as_view()),
    url(r'^entrega/(?P<pk>[0-9]+)$', views.EntregaDetail.as_view()),
    url(r'^entrega/envio/(?P<envio>[0-9]+)$', views.EntregaDetailEnvio.as_view()),
    url(r'^envio/$', views.EnvioList.as_view()),
    url(r'^envio/(?P<pk>[0-9]+)$', views.EnvioDetail.as_view()),
    url(r'^envio/cliente/(?P<cliente>[0-9]+)$', views.EnvioDetailCliente.as_view()),
    url(r'^envio/transportista/(?P<transportista>[0-9]+)/entregado$', views.EnvioDetailTransportistaEntregado.as_view()),
    url(r'^envio/transportista/(?P<transportista>[0-9]+)/pendiente$', views.EnvioDetailTransportistaPendiente.as_view()),
    url(r'^envio/transportista/(?P<transportista>[0-9]+)$', views.EnvioDetailTransportista.as_view()),
    url(r'^transportista/$', views.TransportistaList.as_view()),
    url(r'^transportista/(?P<pk>[0-9]+)$', views.TransportistaDetail.as_view()),
    url(r'^users/$', views.UserList.as_view()),
    url(r'^users/(?P<pk>[0-9]+)/$', views.UserDetail.as_view()),    
    #    url(r'^', include('app.urls')),
]

urlpatterns += [
    url(r'^api-auth/', include('rest_framework.urls', namespace='rest_framework')),
]

urlpatterns = format_suffix_patterns(urlpatterns)


