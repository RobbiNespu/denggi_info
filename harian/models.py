from django.db import models

# Create your models here.

class Daily(models.Model):
	state = models.CharField(max_length=150)
	case_count = models.IntegerField(default=0)
	risk_area_count = models.IntegerField(default=0)