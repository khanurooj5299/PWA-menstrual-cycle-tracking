import pickle
from sklearn import svm
import numpy as np
import sys

#LOADING THE MODEL FROM DISK : (This model was already created in jupyter nb...check PCOS notebook)
loaded_model = pickle.load(open("C:\program files\Ampps\www\menses\pcos\PCOS_SVM.sav",'rb'))

#Creating list from cmd arguments which were passed as a csl
string_list = sys.argv[1].split(',')  #cmd args are always strings
input_list = np.array([float(i) for i in string_list])   #convert all strings to float

#getting predicted probability for this input point
prob_distribution = loaded_model.predict_proba([input_list]) #this func takes as argument a list of data points and returns an array where each element is a probability distribution(list of 2 elements) for each point
prob_having_PCOS = prob_distribution[0][1] #the second element in each probability dist. gives probability of point belonging to the class 1
print("%f%% chance of having PCOS."%(prob_having_PCOS*100))