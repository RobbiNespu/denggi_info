from django.db import models

# Create your models here.

class State(models.Model):
	state = models.CharField(max_length=155)
	area = models.CharField(max_length=155)
	local_area = models.CharField(max_length=155)