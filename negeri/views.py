from django.shortcuts import render
from negeri.models import State
from django.core import serializers
from django.http import HttpResponse
import json
# Create your views here.
def index(request, **kwargs):
	str_negri = kwargs['keyword'];
	raw_data = serializers.serialize('python', State.objects.filter(negeri=str_negri.upper()))
	actual_data = [d['fields'] for d in raw_data]
	data = json.dumps(actual_data)
	return HttpResponse(data, mimetype='application/json');