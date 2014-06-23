from django.shortcuts import render
from harian.models import Daily
from django.core import serializers
from django.http import HttpResponse
import json
# Create your views here.
def index(request):
	raw_data = serializers.serialize('python', Daily.objects.all())
	actual_data = [d['fields'] for d in raw_data]
	data = json.dumps(actual_data)
	return HttpResponse(data, mimetype='application/json')