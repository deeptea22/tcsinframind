import random
from datetime import datetime
import pandas as pd
import numpy as np
import mysql.connector as mariadb
import sys
import nltk
#nltk.download('all')
from nltk import sent_tokenize
from nltk import word_tokenize
from nltk.corpus import stopwords
from nltk import classify
from nltk import NaiveBayesClassifier


#list of stopwords
stopwords = stopwords.words("english")
from nltk import WordNetLemmatizer
column_names = ['sentence','emotion']
path='C:\\Users\\deept\\Documents\\Deepthi\\TCS InfraMind\\Trial2\\test.txt'
df = pd.read_csv(path,sep=';',names=column_names)
print(df.head())
positive=[]
negative=[]
temp=[]
def toString(l):
  word=[]
  for ele in l:
    temp=[]
    for s in ele:
      word.append(s.split())
    #word.append(temp)
  return word

def clean(cln_list):
  c_list=[]  
  for s in cln_list:
    #print(s) 
    clnd_list=[]
    for word in s:
      if word.isalpha():
        if word not in stopwords:
          clnd_list.append(word.lower())
    c_list.append(clnd_list)
    #print(c_list)
  return c_list

def lemm(clean_words):
  lemmet = []
  lemma = WordNetLemmatizer()
  word_list = clean_words
  for s in word_list:
    lem=[]
    for w in s:
      lem.append(lemma.lemmatize(w))
    lemmet.append(lem)
  return lemmet

def get_tweets_for_model(cleaned_tokens_list):
  for tweet_tokens in cleaned_tokens_list:
    yield dict([token, True] for token in tweet_tokens)

for index, rows in df.iterrows():
 if(rows.emotion=='sadness'):
   temp=[rows.sentence]
   negative.append(temp)

#print(negative)
temp=[]
for index, rows in df.iterrows():
 if(rows.emotion=='joy'):
   temp=[rows.sentence]
   positive.append(temp)


negative = toString(negative)
positive = toString(positive)
negative=clean(negative)
positive=clean(positive)
#print(positive)
negative=lemm(negative)
positive=lemm(positive)
#print(positive)


sad_token = get_tweets_for_model(negative)
joy_token = get_tweets_for_model(positive)


negative_dataset = [(tweet_dict, "negative")
                     for tweet_dict in sad_token]

positive_dataset = [(tweet_dict, "positive")
                 for tweet_dict in joy_token]
                           
dataset= positive_dataset + negative_dataset



random.shuffle(dataset)
train_data = dataset[:900]
test_data = dataset[900:]


classifier = NaiveBayesClassifier.train(train_data)

print("Accuracy is:", classify.accuracy(classifier, test_data))

print(classifier.show_most_informative_features(10))



# Connect to MariaDB Platform
try:
    conn = mariadb.connect(
        user="root", #- enter your username
        #password=" " - enter your password        
        database="tcsproject" # - enter your database name

    )
except mariadb.Error as e:
    print(f"Error connecting to MariaDB Platform: {e}")
    sys.exit(1)

# Get Cursor
cur = conn.cursor(buffered=True)
cur.execute(
    "select feedback as custfeed,emoji as emo,time as ts from custfeedback where sentiment is null")
for (custfeed,emo,ts) in cur:
    print(f"feedback: {custfeed},{emo},{ts}")
    custom_tokens = (word_tokenize(custfeed))
    senti=classifier.classify(dict([token, True] for token in custom_tokens))
    timest=str(ts)
    print(senti,timest)
    try:
      conn2 = mariadb.connect(
        user="root",#- enter your username
        #password=" " - enter your password        
        database="tcsproject" # - enter your database name

      )
    except mariadb.Error as e:
      print(f"Error connecting to MariaDB Platform: {e}")
      sys.exit(1)
    updcur=conn2.cursor()
    updcur.execute("update custfeedback set sentiment = %s where Time = %s",(senti,timest))
    conn2.commit()
conn.close()




