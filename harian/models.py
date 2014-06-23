from django.db import models

# Create your models here.

class Daily(models.Model):
	negeri = models.CharField(max_length=150)
	jumlah_kes = models.IntegerField(default=0)
	kawasan_berisiko = models.IntegerField(default=0)
	
	def __unicode__(self):
		return self.name