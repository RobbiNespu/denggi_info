from django.shortcuts import render
from harian.models import Daily
from django.core import serializers
from django.http import HttpResponse
# Create your views here.
def index(request):
	daily_dta = Daily.objects.all()
	daily_dta = serializers.serialize('json', daily_dta, indent=4)
	return HttpResponse(daily_dta, mimetype='application/json')