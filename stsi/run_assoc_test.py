##!/usr/bin/python
# run_assoc_test: this file simply takes data from a gwas file and runs a
# chi-squared test to determine if any SNPs are statistically significant.
# To use:
#   (1) cd to/the/directory/where/the/.ped/file/is
#   (2) save this python file in that directory
#   (3a) run using this command(rename file names as appropriate):
#       python pythonfile.py pedfile.ped output.txt > output2.txt
#       this will allow you to store the print statements in a file for later use
#       Note: the output can be whatever output format you choose
#   (3b)an alternative command is:    
#       python pythonfile.py pedfile.ped outputfile.txt 
#       this will display all print commands on the command line
#       Note: the output can be whatever output format you choose
# Mollee Jain, (TSRI-STSI Intern, Aug 2013)

###PLEASE READ#####    
#############################NOTES:###########################################
#SCIPY: this file imports stats from the scipy module.  This allows us to calculate the p-value from a chi-squared test.  This needs to be downloaded before use of this file. For Linux Mint 15 Olivia I simply opened the Synaptic Package Manager and installed scipy. 

#TYPE OF CHI-SQUARED TEST: This program runs a chi-squared test as a 2X2 contingency table.  The calculated p-value is standard - the Fisher Exact Test and the Yates Correction are not utilized in the p-value calculation.

#DEGRESS OF FREEDOM:the degrees of freedom (df) for this test is 1.  If df for your sample is not 1, you will need to edit this code under the 'pvalue' function. 

#WHERE TO START: the numbers 6 and 7 indicate where the first pair of nucleotides are.  Change these numbers in the 'run' function if the location of the first pair of nucleotides are not at '6'&'7'.  To find the location of the first pair of nucleotides - print the line variable on line 122 and count (starting from 0) to see where the first nucleotide is
##############################################################################


#imports
from sys import argv 
from collections import Counter 
from scipy import stats             #allows us to calculate the p-value
import math


#arguments to be provided
script, filename, output = argv
    #script - this file
    #filename - GWAS file (typically in .ped format; i.e. genotypes.ped)
    #output - file to write results to (in whatever format you choose; i.e. sampleoutput.txt)

########################DEFINITIONS/LISTS:###################################
to_file = open(output, 'w') #output file
first = []                  #a list of the first nucleotide of the SNP pair(ex.'C' in CG)
second = []                 #a list of the second nucleo. of the SNP pair(ex. 'G' in CG)
chi = []                    #a list that will help compute the chi-squared value
count1 = []                 #a list for the count of nucleotides (1st in the pair)
count2 = []                 #a list for the count of nucleotides (2nd in the pair)

########################FUNCTIONS:##########################################

### A function to split GWAS file to separate pairs of SNPS (ex.AG) ###
def split_snp(x,y):
    with open(filename) as f:
        for snpfile in f:
            line = snpfile.split(" ")   #split each line in .ped file by spaces
            firstpart = line[x]         #first nucleo. of the SNP pair
            secondpart = line[y]        #second nucleo. of the SNP pair
            first.append(firstpart)     #append first nucleo. to list 'first'
            second.append(secondpart)   #append second nucelo. to list 'second'      
        
                     
    f.close()                       
                  

### A function to calculate the chisquared value of a pair of SNPs ###
def chisq():
    #a count of whatever is in the column (i.e. count of how many C 
    #and G's are in the first column of the SNPs)
    firstcounter = Counter(first)
    secondcounter = Counter(second)
    count1.append(firstcounter)             
    count2.append(secondcounter)       
    
    if len(first) == len(second):    #a count of items in a row --
        total_row = len(first)       #the counts should be the same!
    else: 
        print "Error: the length of each column is not the same."
    del first[:]                 #empties lists to allow for lists to be reused
    del second[:]                
    
    #setup for a chisquared with expected and observed values      
    for i in firstcounter or secondcounter:
        total_column = firstcounter[i] + secondcounter[i]       #gives total of counts
        expected = float(total_column*total_row)/(total_row*2)  #expected counts formula
        
        #(to see observed and expected values, print the line below:)
        #print i,firstcounter[i],secondcounter[i],"||",expected
        
        chisq = "%0.5f"%(((firstcounter[i]-expected)**2/expected) + ((secondcounter[i]-expected)**2/expected))            #calculation of the chi-squared value
        chi.append(float(chisq))   #appends chi-squared value to a list 'chi'
        
    return sum(chi)                #returns the value of the chi-squared test

### A function to calculate the p-value of the chi-square value of a SNP pair ###
def pvalue():
    chisq_value = float(sum(chi))                       
    print "CHI-SQUARED VALUE: " + str(chisq_value)      
    df = float(1)                                       #degrees of freedom - see NOTES
    p_value = 1 - stats.chi2.cdf(float(chisq_value),df) #using scipy to calculate pvalue
    print "P-VALUE: " + str(p_value)            
    print count1,count2   
    
    significance = 1.0e-8       #alter this variable to output more/less significant
                                #p-values to the output file
    if p_value < significance:
        to_file.write(str(count1))
        to_file.write(str(count2))
        to_file.write("\t")
        to_file.write(str(p_value))
        to_file.write("\t")
        to_file.write(str(chisq()))
        to_file.write("\n")
    else:
        None
 

####A function to run the whole program######
def run(x,y):
    with open(filename) as f:
        for snpfile in f:
            line = snpfile.split(" ")       #split each line in .ped file by spaces
            for i in range (6,len(line)-2): #loops over each SNP pair in the data set
                print "\n"
                #loops through the length of the gwas file to do a chi-squared test
                #stops when there are no further nucleotides
                if x != 6 and y != 7:       
                    try:           
                        split_snp(x,y)
                        print "PAIR ID: " + str(x) + " and " + str(y)
                        x += 2
                        y += 2    
                        chisq()
                        pvalue()
                        del count1[:]       #empties lists to allow for lists to be reused
                        del count2[:]
                        del chi[:]
                    #signals the for loop to stop    
                    except:
                        break
                
                #this starts off the loop at the first pair of nucleotides
                else:                      
                    print "PAIR ID: " + str(x) + " and " + str(y)
                    split_snp(x,y)
                    x += 2
                    y += 2    
                    chisq()
                    pvalue()
                    del count1[:]        #empties lists to allow for lists to be reused
                    del count2[:]
                    del chi[:]
    f.close()


to_file.write(" Count of nucleotides in SNP Pair    ||| ")
to_file.write("\t")
to_file.write("P-Value      ||| ")
to_file.write("\t")
to_file.write("Chi-Squared Value")
to_file.write("\n\n")

run(6,7)        #runs the whole program.  



