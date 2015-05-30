<!-- HTML generated using hilite.me --><div style="background: #f8f8f8; overflow:auto;height:250px;border-style:solid;border-color:#4E4F4B;font-size: 12px;border-width:2px;padding:.2em .2em;"><pre style="margin: 0; line-height: 125%">#!/bin/bash
#PBS -l walltime=12:00:00
#PBS -N nameofrunfile
#PBS -m abe
#PBS -l nodes=1:ppn=1
#PBS -o /pathway/to/the/output/filename.oe
#PBS -j oe
#PBS -M email@example.edu
#PBS -V 


#MAKE SURE FILE HAS PERMISSIONS NEEDED
# Tell it to go to this directory
cd /pathway/to/the/directory/needed
#load novocraft
module load novocraft


# formula: novoalign -d reference_genome -f filename1 filename2 -i mean, stdev -o SAM
# -d = database index
# -f = forced to read file
# -i = specify orientation model of read pairs for novoalign to process
# -o = output



novoalign -d ref.nix -f ../Sample/file1.fastq.gz ../ Sample/file2.fastq.gz -i 250,90 -o SAM &gt; *.SAM

#rename files as appropriate
</pre></div>

