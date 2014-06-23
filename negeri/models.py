from django.db import models

# Create your models here.

class State(models.Model):
	negeri = models.CharField(max_length=155)
	daerah = models.CharField(max_length=155)
	lokaliti = models.CharField(max_length=155)