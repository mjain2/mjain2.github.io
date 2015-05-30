<!-- HTML generated using hilite.me --><div style="background: #f8f8f8; overflow:auto;height:300px;border-style:solid;border-color:#4E4F4B;font-size: 12px;border-width:2px;padding:.2em .2em;"><table><tr><td><pre style="margin: 0; line-height: 125%">  1
  2
  3
  4
  5
  6
  7
  8
  9
 10
 11
 12
 13
 14
 15
 16
 17
 18
 19
 20
 21
 22
 23
 24
 25
 26
 27
 28
 29
 30
 31
 32
 33
 34
 35
 36
 37
 38
 39
 40
 41
 42
 43
 44
 45
 46
 47
 48
 49
 50
 51
 52
 53
 54
 55
 56
 57
 58
 59
 60
 61
 62
 63
 64
 65
 66
 67
 68
 69
 70
 71
 72
 73
 74
 75
 76
 77
 78
 79
 80
 81
 82
 83
 84
 85
 86
 87
 88
 89
 90
 91
 92
 93
 94
 95
 96
 97
 98
 99
100
101
102
103
104
105
106
107
108
109
110
111
112
113
114
115
116
117
118
119
120
121
122
123
124
125
126
127
128
129
130
131
132
133
134
135
136
137
138
139
140
141
142
143
144
145
146
147
148
149
150
151
152
153
154
155
156
157
158
159
160
161
162
163</pre></td><td><pre style="margin: 0; line-height: 125%"><span style="color: #8f5902; font-style: italic">##!/usr/bin/python</span>
<span style="color: #8f5902; font-style: italic"># run_assoc_test: this file simply takes data from a gwas file and runs a</span>
<span style="color: #8f5902; font-style: italic"># chi-squared test to determine if any SNPs are statistically significant.</span>
<span style="color: #8f5902; font-style: italic"># To use:</span>
<span style="color: #8f5902; font-style: italic">#   (1) cd to/the/directory/where/the/.ped/file/is</span>
<span style="color: #8f5902; font-style: italic">#   (2) save this python file in that directory</span>
<span style="color: #8f5902; font-style: italic">#   (3a) run using this command(rename file names as appropriate):</span>
<span style="color: #8f5902; font-style: italic">#       python pythonfile.py pedfile.ped output.txt &gt; output2.txt</span>
<span style="color: #8f5902; font-style: italic">#       this will allow you to store the print statements in a file for later use</span>
<span style="color: #8f5902; font-style: italic">#       Note: the output can be whatever output format you choose</span>
<span style="color: #8f5902; font-style: italic">#   (3b)an alternative command is:    </span>
<span style="color: #8f5902; font-style: italic">#       python pythonfile.py pedfile.ped outputfile.txt </span>
<span style="color: #8f5902; font-style: italic">#       this will display all print commands on the command line</span>
<span style="color: #8f5902; font-style: italic">#       Note: the output can be whatever output format you choose</span>
<span style="color: #8f5902; font-style: italic"># Mollee Jain, (TSRI-STSI Intern, Aug 2013)</span>

<span style="color: #8f5902; font-style: italic">###PLEASE READ#####    </span>
<span style="color: #8f5902; font-style: italic">#############################NOTES:###########################################</span>
<span style="color: #8f5902; font-style: italic">#SCIPY: this file imports stats from the scipy module.  This allows us to calculate the p-value from a chi-squared test.  This needs to be downloaded before use of this file. For Linux Mint 15 Olivia I simply opened the Synaptic Package Manager and installed scipy. </span>

<span style="color: #8f5902; font-style: italic">#TYPE OF CHI-SQUARED TEST: This program runs a chi-squared test as a 2X2 contingency table.  The calculated p-value is standard - the Fisher Exact Test and the Yates Correction are not utilized in the p-value calculation.</span>

<span style="color: #8f5902; font-style: italic">#DEGRESS OF FREEDOM:the degrees of freedom (df) for this test is 1.  If df for your sample is not 1, you will need to edit this code under the &#39;pvalue&#39; function. </span>

<span style="color: #8f5902; font-style: italic">#WHERE TO START: the numbers 6 and 7 indicate where the first pair of nucleotides are.  Change these numbers in the &#39;run&#39; function if the location of the first pair of nucleotides are not at &#39;6&#39;&amp;&#39;7&#39;.  To find the location of the first pair of nucleotides - print the line variable on line 122 and count (starting from 0) to see where the first nucleotide is</span>
<span style="color: #8f5902; font-style: italic">##############################################################################</span>


<span style="color: #8f5902; font-style: italic">#imports</span>
<span style="color: #204a87; font-weight: bold">from</span> <span style="color: #000000">sys</span> <span style="color: #204a87; font-weight: bold">import</span> <span style="color: #000000">argv</span> 
<span style="color: #204a87; font-weight: bold">from</span> <span style="color: #000000">collections</span> <span style="color: #204a87; font-weight: bold">import</span> <span style="color: #000000">Counter</span> 
<span style="color: #204a87; font-weight: bold">from</span> <span style="color: #000000">scipy</span> <span style="color: #204a87; font-weight: bold">import</span> <span style="color: #000000">stats</span>             <span style="color: #8f5902; font-style: italic">#allows us to calculate the p-value</span>
<span style="color: #204a87; font-weight: bold">import</span> <span style="color: #000000">math</span>


<span style="color: #8f5902; font-style: italic">#arguments to be provided</span>
<span style="color: #000000">script</span><span style="color: #000000; font-weight: bold">,</span> <span style="color: #000000">filename</span><span style="color: #000000; font-weight: bold">,</span> <span style="color: #000000">output</span> <span style="color: #ce5c00; font-weight: bold">=</span> <span style="color: #000000">argv</span>
    <span style="color: #8f5902; font-style: italic">#script - this file</span>
    <span style="color: #8f5902; font-style: italic">#filename - GWAS file (typically in .ped format; i.e. genotypes.ped)</span>
    <span style="color: #8f5902; font-style: italic">#output - file to write results to (in whatever format you choose; i.e. sampleoutput.txt)</span>

<span style="color: #8f5902; font-style: italic">########################DEFINITIONS/LISTS:###################################</span>
<span style="color: #000000">to_file</span> <span style="color: #ce5c00; font-weight: bold">=</span> <span style="color: #204a87">open</span><span style="color: #000000; font-weight: bold">(</span><span style="color: #000000">output</span><span style="color: #000000; font-weight: bold">,</span> <span style="color: #4e9a06">&#39;w&#39;</span><span style="color: #000000; font-weight: bold">)</span> <span style="color: #8f5902; font-style: italic">#output file</span>
<span style="color: #000000">first</span> <span style="color: #ce5c00; font-weight: bold">=</span> <span style="color: #000000; font-weight: bold">[]</span>                  <span style="color: #8f5902; font-style: italic">#a list of the first nucleotide of the SNP pair(ex.&#39;C&#39; in CG)</span>
<span style="color: #000000">second</span> <span style="color: #ce5c00; font-weight: bold">=</span> <span style="color: #000000; font-weight: bold">[]</span>                 <span style="color: #8f5902; font-style: italic">#a list of the second nucleo. of the SNP pair(ex. &#39;G&#39; in CG)</span>
<span style="color: #000000">chi</span> <span style="color: #ce5c00; font-weight: bold">=</span> <span style="color: #000000; font-weight: bold">[]</span>                    <span style="color: #8f5902; font-style: italic">#a list that will help compute the chi-squared value</span>
<span style="color: #000000">count1</span> <span style="color: #ce5c00; font-weight: bold">=</span> <span style="color: #000000; font-weight: bold">[]</span>                 <span style="color: #8f5902; font-style: italic">#a list for the count of nucleotides (1st in the pair)</span>
<span style="color: #000000">count2</span> <span style="color: #ce5c00; font-weight: bold">=</span> <span style="color: #000000; font-weight: bold">[]</span>                 <span style="color: #8f5902; font-style: italic">#a list for the count of nucleotides (2nd in the pair)</span>

<span style="color: #8f5902; font-style: italic">########################FUNCTIONS:##########################################</span>

<span style="color: #8f5902; font-style: italic">### A function to split GWAS file to separate pairs of SNPS (ex.AG) ###</span>
<span style="color: #204a87; font-weight: bold">def</span> <span style="color: #000000">split_snp</span><span style="color: #000000; font-weight: bold">(</span><span style="color: #000000">x</span><span style="color: #000000; font-weight: bold">,</span><span style="color: #000000">y</span><span style="color: #000000; font-weight: bold">):</span>
    <span style="color: #204a87; font-weight: bold">with</span> <span style="color: #204a87">open</span><span style="color: #000000; font-weight: bold">(</span><span style="color: #000000">filename</span><span style="color: #000000; font-weight: bold">)</span> <span style="color: #204a87; font-weight: bold">as</span> <span style="color: #000000">f</span><span style="color: #000000; font-weight: bold">:</span>
        <span style="color: #204a87; font-weight: bold">for</span> <span style="color: #000000">snpfile</span> <span style="color: #204a87; font-weight: bold">in</span> <span style="color: #000000">f</span><span style="color: #000000; font-weight: bold">:</span>
            <span style="color: #000000">line</span> <span style="color: #ce5c00; font-weight: bold">=</span> <span style="color: #000000">snpfile</span><span style="color: #ce5c00; font-weight: bold">.</span><span style="color: #000000">split</span><span style="color: #000000; font-weight: bold">(</span><span style="color: #4e9a06">&quot; &quot;</span><span style="color: #000000; font-weight: bold">)</span>   <span style="color: #8f5902; font-style: italic">#split each line in .ped file by spaces</span>
            <span style="color: #000000">firstpart</span> <span style="color: #ce5c00; font-weight: bold">=</span> <span style="color: #000000">line</span><span style="color: #000000; font-weight: bold">[</span><span style="color: #000000">x</span><span style="color: #000000; font-weight: bold">]</span>         <span style="color: #8f5902; font-style: italic">#first nucleo. of the SNP pair</span>
            <span style="color: #000000">secondpart</span> <span style="color: #ce5c00; font-weight: bold">=</span> <span style="color: #000000">line</span><span style="color: #000000; font-weight: bold">[</span><span style="color: #000000">y</span><span style="color: #000000; font-weight: bold">]</span>        <span style="color: #8f5902; font-style: italic">#second nucleo. of the SNP pair</span>
            <span style="color: #000000">first</span><span style="color: #ce5c00; font-weight: bold">.</span><span style="color: #000000">append</span><span style="color: #000000; font-weight: bold">(</span><span style="color: #000000">firstpart</span><span style="color: #000000; font-weight: bold">)</span>     <span style="color: #8f5902; font-style: italic">#append first nucleo. to list &#39;first&#39;</span>
            <span style="color: #000000">second</span><span style="color: #ce5c00; font-weight: bold">.</span><span style="color: #000000">append</span><span style="color: #000000; font-weight: bold">(</span><span style="color: #000000">secondpart</span><span style="color: #000000; font-weight: bold">)</span>   <span style="color: #8f5902; font-style: italic">#append second nucelo. to list &#39;second&#39;      </span>
        
                     
    <span style="color: #000000">f</span><span style="color: #ce5c00; font-weight: bold">.</span><span style="color: #000000">close</span><span style="color: #000000; font-weight: bold">()</span>                       
                  

<span style="color: #8f5902; font-style: italic">### A function to calculate the chisquared value of a pair of SNPs ###</span>
<span style="color: #204a87; font-weight: bold">def</span> <span style="color: #000000">chisq</span><span style="color: #000000; font-weight: bold">():</span>
    <span style="color: #8f5902; font-style: italic">#a count of whatever is in the column (i.e. count of how many C </span>
    <span style="color: #8f5902; font-style: italic">#and G&#39;s are in the first column of the SNPs)</span>
    <span style="color: #000000">firstcounter</span> <span style="color: #ce5c00; font-weight: bold">=</span> <span style="color: #000000">Counter</span><span style="color: #000000; font-weight: bold">(</span><span style="color: #000000">first</span><span style="color: #000000; font-weight: bold">)</span>
    <span style="color: #000000">secondcounter</span> <span style="color: #ce5c00; font-weight: bold">=</span> <span style="color: #000000">Counter</span><span style="color: #000000; font-weight: bold">(</span><span style="color: #000000">second</span><span style="color: #000000; font-weight: bold">)</span>
    <span style="color: #000000">count1</span><span style="color: #ce5c00; font-weight: bold">.</span><span style="color: #000000">append</span><span style="color: #000000; font-weight: bold">(</span><span style="color: #000000">firstcounter</span><span style="color: #000000; font-weight: bold">)</span>             
    <span style="color: #000000">count2</span><span style="color: #ce5c00; font-weight: bold">.</span><span style="color: #000000">append</span><span style="color: #000000; font-weight: bold">(</span><span style="color: #000000">secondcounter</span><span style="color: #000000; font-weight: bold">)</span>       
    
    <span style="color: #204a87; font-weight: bold">if</span> <span style="color: #204a87">len</span><span style="color: #000000; font-weight: bold">(</span><span style="color: #000000">first</span><span style="color: #000000; font-weight: bold">)</span> <span style="color: #ce5c00; font-weight: bold">==</span> <span style="color: #204a87">len</span><span style="color: #000000; font-weight: bold">(</span><span style="color: #000000">second</span><span style="color: #000000; font-weight: bold">):</span>    <span style="color: #8f5902; font-style: italic">#a count of items in a row --</span>
        <span style="color: #000000">total_row</span> <span style="color: #ce5c00; font-weight: bold">=</span> <span style="color: #204a87">len</span><span style="color: #000000; font-weight: bold">(</span><span style="color: #000000">first</span><span style="color: #000000; font-weight: bold">)</span>       <span style="color: #8f5902; font-style: italic">#the counts should be the same!</span>
    <span style="color: #204a87; font-weight: bold">else</span><span style="color: #000000; font-weight: bold">:</span> 
        <span style="color: #204a87; font-weight: bold">print</span> <span style="color: #4e9a06">&quot;Error: the length of each column is not the same.&quot;</span>
    <span style="color: #204a87; font-weight: bold">del</span> <span style="color: #000000">first</span><span style="color: #000000; font-weight: bold">[:]</span>                 <span style="color: #8f5902; font-style: italic">#empties lists to allow for lists to be reused</span>
    <span style="color: #204a87; font-weight: bold">del</span> <span style="color: #000000">second</span><span style="color: #000000; font-weight: bold">[:]</span>                
    
    <span style="color: #8f5902; font-style: italic">#setup for a chisquared with expected and observed values      </span>
    <span style="color: #204a87; font-weight: bold">for</span> <span style="color: #000000">i</span> <span style="color: #204a87; font-weight: bold">in</span> <span style="color: #000000">firstcounter</span> <span style="color: #204a87; font-weight: bold">or</span> <span style="color: #000000">secondcounter</span><span style="color: #000000; font-weight: bold">:</span>
        <span style="color: #000000">total_column</span> <span style="color: #ce5c00; font-weight: bold">=</span> <span style="color: #000000">firstcounter</span><span style="color: #000000; font-weight: bold">[</span><span style="color: #000000">i</span><span style="color: #000000; font-weight: bold">]</span> <span style="color: #ce5c00; font-weight: bold">+</span> <span style="color: #000000">secondcounter</span><span style="color: #000000; font-weight: bold">[</span><span style="color: #000000">i</span><span style="color: #000000; font-weight: bold">]</span>       <span style="color: #8f5902; font-style: italic">#gives total of counts</span>
        <span style="color: #000000">expected</span> <span style="color: #ce5c00; font-weight: bold">=</span> <span style="color: #204a87">float</span><span style="color: #000000; font-weight: bold">(</span><span style="color: #000000">total_column</span><span style="color: #ce5c00; font-weight: bold">*</span><span style="color: #000000">total_row</span><span style="color: #000000; font-weight: bold">)</span><span style="color: #ce5c00; font-weight: bold">/</span><span style="color: #000000; font-weight: bold">(</span><span style="color: #000000">total_row</span><span style="color: #ce5c00; font-weight: bold">*</span><span style="color: #0000cf; font-weight: bold">2</span><span style="color: #000000; font-weight: bold">)</span>  <span style="color: #8f5902; font-style: italic">#expected counts formula</span>
        
        <span style="color: #8f5902; font-style: italic">#(to see observed and expected values, print the line below:)</span>
        <span style="color: #8f5902; font-style: italic">#print i,firstcounter[i],secondcounter[i],&quot;||&quot;,expected</span>
        
        <span style="color: #000000">chisq</span> <span style="color: #ce5c00; font-weight: bold">=</span> <span style="color: #4e9a06">&quot;%0.5f&quot;</span><span style="color: #ce5c00; font-weight: bold">%</span><span style="color: #000000; font-weight: bold">(((</span><span style="color: #000000">firstcounter</span><span style="color: #000000; font-weight: bold">[</span><span style="color: #000000">i</span><span style="color: #000000; font-weight: bold">]</span><span style="color: #ce5c00; font-weight: bold">-</span><span style="color: #000000">expected</span><span style="color: #000000; font-weight: bold">)</span><span style="color: #ce5c00; font-weight: bold">**</span><span style="color: #0000cf; font-weight: bold">2</span><span style="color: #ce5c00; font-weight: bold">/</span><span style="color: #000000">expected</span><span style="color: #000000; font-weight: bold">)</span> <span style="color: #ce5c00; font-weight: bold">+</span> <span style="color: #000000; font-weight: bold">((</span><span style="color: #000000">secondcounter</span><span style="color: #000000; font-weight: bold">[</span><span style="color: #000000">i</span><span style="color: #000000; font-weight: bold">]</span><span style="color: #ce5c00; font-weight: bold">-</span><span style="color: #000000">expected</span><span style="color: #000000; font-weight: bold">)</span><span style="color: #ce5c00; font-weight: bold">**</span><span style="color: #0000cf; font-weight: bold">2</span><span style="color: #ce5c00; font-weight: bold">/</span><span style="color: #000000">expected</span><span style="color: #000000; font-weight: bold">))</span>            <span style="color: #8f5902; font-style: italic">#calculation of the chi-squared value</span>
        <span style="color: #000000">chi</span><span style="color: #ce5c00; font-weight: bold">.</span><span style="color: #000000">append</span><span style="color: #000000; font-weight: bold">(</span><span style="color: #204a87">float</span><span style="color: #000000; font-weight: bold">(</span><span style="color: #000000">chisq</span><span style="color: #000000; font-weight: bold">))</span>   <span style="color: #8f5902; font-style: italic">#appends chi-squared value to a list &#39;chi&#39;</span>
        
    <span style="color: #204a87; font-weight: bold">return</span> <span style="color: #204a87">sum</span><span style="color: #000000; font-weight: bold">(</span><span style="color: #000000">chi</span><span style="color: #000000; font-weight: bold">)</span>                <span style="color: #8f5902; font-style: italic">#returns the value of the chi-squared test</span>

<span style="color: #8f5902; font-style: italic">### A function to calculate the p-value of the chi-square value of a SNP pair ###</span>
<span style="color: #204a87; font-weight: bold">def</span> <span style="color: #000000">pvalue</span><span style="color: #000000; font-weight: bold">():</span>
    <span style="color: #000000">chisq_value</span> <span style="color: #ce5c00; font-weight: bold">=</span> <span style="color: #204a87">float</span><span style="color: #000000; font-weight: bold">(</span><span style="color: #204a87">sum</span><span style="color: #000000; font-weight: bold">(</span><span style="color: #000000">chi</span><span style="color: #000000; font-weight: bold">))</span>                       
    <span style="color: #204a87; font-weight: bold">print</span> <span style="color: #4e9a06">&quot;CHI-SQUARED VALUE: &quot;</span> <span style="color: #ce5c00; font-weight: bold">+</span> <span style="color: #204a87">str</span><span style="color: #000000; font-weight: bold">(</span><span style="color: #000000">chisq_value</span><span style="color: #000000; font-weight: bold">)</span>      
    <span style="color: #000000">df</span> <span style="color: #ce5c00; font-weight: bold">=</span> <span style="color: #204a87">float</span><span style="color: #000000; font-weight: bold">(</span><span style="color: #0000cf; font-weight: bold">1</span><span style="color: #000000; font-weight: bold">)</span>                                       <span style="color: #8f5902; font-style: italic">#degrees of freedom - see NOTES</span>
    <span style="color: #000000">p_value</span> <span style="color: #ce5c00; font-weight: bold">=</span> <span style="color: #0000cf; font-weight: bold">1</span> <span style="color: #ce5c00; font-weight: bold">-</span> <span style="color: #000000">stats</span><span style="color: #ce5c00; font-weight: bold">.</span><span style="color: #000000">chi2</span><span style="color: #ce5c00; font-weight: bold">.</span><span style="color: #000000">cdf</span><span style="color: #000000; font-weight: bold">(</span><span style="color: #204a87">float</span><span style="color: #000000; font-weight: bold">(</span><span style="color: #000000">chisq_value</span><span style="color: #000000; font-weight: bold">),</span><span style="color: #000000">df</span><span style="color: #000000; font-weight: bold">)</span> <span style="color: #8f5902; font-style: italic">#using scipy to calculate pvalue</span>
    <span style="color: #204a87; font-weight: bold">print</span> <span style="color: #4e9a06">&quot;P-VALUE: &quot;</span> <span style="color: #ce5c00; font-weight: bold">+</span> <span style="color: #204a87">str</span><span style="color: #000000; font-weight: bold">(</span><span style="color: #000000">p_value</span><span style="color: #000000; font-weight: bold">)</span>            
    <span style="color: #204a87; font-weight: bold">print</span> <span style="color: #000000">count1</span><span style="color: #000000; font-weight: bold">,</span><span style="color: #000000">count2</span>   
    
    <span style="color: #000000">significance</span> <span style="color: #ce5c00; font-weight: bold">=</span> <span style="color: #0000cf; font-weight: bold">1.0e-8</span>       <span style="color: #8f5902; font-style: italic">#alter this variable to output more/less significant</span>
                                <span style="color: #8f5902; font-style: italic">#p-values to the output file</span>
    <span style="color: #204a87; font-weight: bold">if</span> <span style="color: #000000">p_value</span> <span style="color: #ce5c00; font-weight: bold">&lt;</span> <span style="color: #000000">significance</span><span style="color: #000000; font-weight: bold">:</span>
        <span style="color: #000000">to_file</span><span style="color: #ce5c00; font-weight: bold">.</span><span style="color: #000000">write</span><span style="color: #000000; font-weight: bold">(</span><span style="color: #204a87">str</span><span style="color: #000000; font-weight: bold">(</span><span style="color: #000000">count1</span><span style="color: #000000; font-weight: bold">))</span>
        <span style="color: #000000">to_file</span><span style="color: #ce5c00; font-weight: bold">.</span><span style="color: #000000">write</span><span style="color: #000000; font-weight: bold">(</span><span style="color: #204a87">str</span><span style="color: #000000; font-weight: bold">(</span><span style="color: #000000">count2</span><span style="color: #000000; font-weight: bold">))</span>
        <span style="color: #000000">to_file</span><span style="color: #ce5c00; font-weight: bold">.</span><span style="color: #000000">write</span><span style="color: #000000; font-weight: bold">(</span><span style="color: #4e9a06">&quot;\t&quot;</span><span style="color: #000000; font-weight: bold">)</span>
        <span style="color: #000000">to_file</span><span style="color: #ce5c00; font-weight: bold">.</span><span style="color: #000000">write</span><span style="color: #000000; font-weight: bold">(</span><span style="color: #204a87">str</span><span style="color: #000000; font-weight: bold">(</span><span style="color: #000000">p_value</span><span style="color: #000000; font-weight: bold">))</span>
        <span style="color: #000000">to_file</span><span style="color: #ce5c00; font-weight: bold">.</span><span style="color: #000000">write</span><span style="color: #000000; font-weight: bold">(</span><span style="color: #4e9a06">&quot;\t&quot;</span><span style="color: #000000; font-weight: bold">)</span>
        <span style="color: #000000">to_file</span><span style="color: #ce5c00; font-weight: bold">.</span><span style="color: #000000">write</span><span style="color: #000000; font-weight: bold">(</span><span style="color: #204a87">str</span><span style="color: #000000; font-weight: bold">(</span><span style="color: #000000">chisq</span><span style="color: #000000; font-weight: bold">()))</span>
        <span style="color: #000000">to_file</span><span style="color: #ce5c00; font-weight: bold">.</span><span style="color: #000000">write</span><span style="color: #000000; font-weight: bold">(</span><span style="color: #4e9a06">&quot;\n&quot;</span><span style="color: #000000; font-weight: bold">)</span>
    <span style="color: #204a87; font-weight: bold">else</span><span style="color: #000000; font-weight: bold">:</span>
        <span style="color: #3465a4">None</span>
 

<span style="color: #8f5902; font-style: italic">####A function to run the whole program######</span>
<span style="color: #204a87; font-weight: bold">def</span> <span style="color: #000000">run</span><span style="color: #000000; font-weight: bold">(</span><span style="color: #000000">x</span><span style="color: #000000; font-weight: bold">,</span><span style="color: #000000">y</span><span style="color: #000000; font-weight: bold">):</span>
    <span style="color: #204a87; font-weight: bold">with</span> <span style="color: #204a87">open</span><span style="color: #000000; font-weight: bold">(</span><span style="color: #000000">filename</span><span style="color: #000000; font-weight: bold">)</span> <span style="color: #204a87; font-weight: bold">as</span> <span style="color: #000000">f</span><span style="color: #000000; font-weight: bold">:</span>
        <span style="color: #204a87; font-weight: bold">for</span> <span style="color: #000000">snpfile</span> <span style="color: #204a87; font-weight: bold">in</span> <span style="color: #000000">f</span><span style="color: #000000; font-weight: bold">:</span>
            <span style="color: #000000">line</span> <span style="color: #ce5c00; font-weight: bold">=</span> <span style="color: #000000">snpfile</span><span style="color: #ce5c00; font-weight: bold">.</span><span style="color: #000000">split</span><span style="color: #000000; font-weight: bold">(</span><span style="color: #4e9a06">&quot; &quot;</span><span style="color: #000000; font-weight: bold">)</span>       <span style="color: #8f5902; font-style: italic">#split each line in .ped file by spaces</span>
            <span style="color: #204a87; font-weight: bold">for</span> <span style="color: #000000">i</span> <span style="color: #204a87; font-weight: bold">in</span> <span style="color: #204a87">range</span> <span style="color: #000000; font-weight: bold">(</span><span style="color: #0000cf; font-weight: bold">6</span><span style="color: #000000; font-weight: bold">,</span><span style="color: #204a87">len</span><span style="color: #000000; font-weight: bold">(</span><span style="color: #000000">line</span><span style="color: #000000; font-weight: bold">)</span><span style="color: #ce5c00; font-weight: bold">-</span><span style="color: #0000cf; font-weight: bold">2</span><span style="color: #000000; font-weight: bold">):</span> <span style="color: #8f5902; font-style: italic">#loops over each SNP pair in the data set</span>
                <span style="color: #204a87; font-weight: bold">print</span> <span style="color: #4e9a06">&quot;\n&quot;</span>
                <span style="color: #8f5902; font-style: italic">#loops through the length of the gwas file to do a chi-squared test</span>
                <span style="color: #8f5902; font-style: italic">#stops when there are no further nucleotides</span>
                <span style="color: #204a87; font-weight: bold">if</span> <span style="color: #000000">x</span> <span style="color: #ce5c00; font-weight: bold">!=</span> <span style="color: #0000cf; font-weight: bold">6</span> <span style="color: #204a87; font-weight: bold">and</span> <span style="color: #000000">y</span> <span style="color: #ce5c00; font-weight: bold">!=</span> <span style="color: #0000cf; font-weight: bold">7</span><span style="color: #000000; font-weight: bold">:</span>       
                    <span style="color: #204a87; font-weight: bold">try</span><span style="color: #000000; font-weight: bold">:</span>           
                        <span style="color: #000000">split_snp</span><span style="color: #000000; font-weight: bold">(</span><span style="color: #000000">x</span><span style="color: #000000; font-weight: bold">,</span><span style="color: #000000">y</span><span style="color: #000000; font-weight: bold">)</span>
                        <span style="color: #204a87; font-weight: bold">print</span> <span style="color: #4e9a06">&quot;PAIR ID: &quot;</span> <span style="color: #ce5c00; font-weight: bold">+</span> <span style="color: #204a87">str</span><span style="color: #000000; font-weight: bold">(</span><span style="color: #000000">x</span><span style="color: #000000; font-weight: bold">)</span> <span style="color: #ce5c00; font-weight: bold">+</span> <span style="color: #4e9a06">&quot; and &quot;</span> <span style="color: #ce5c00; font-weight: bold">+</span> <span style="color: #204a87">str</span><span style="color: #000000; font-weight: bold">(</span><span style="color: #000000">y</span><span style="color: #000000; font-weight: bold">)</span>
                        <span style="color: #000000">x</span> <span style="color: #ce5c00; font-weight: bold">+=</span> <span style="color: #0000cf; font-weight: bold">2</span>
                        <span style="color: #000000">y</span> <span style="color: #ce5c00; font-weight: bold">+=</span> <span style="color: #0000cf; font-weight: bold">2</span>    
                        <span style="color: #000000">chisq</span><span style="color: #000000; font-weight: bold">()</span>
                        <span style="color: #000000">pvalue</span><span style="color: #000000; font-weight: bold">()</span>
                        <span style="color: #204a87; font-weight: bold">del</span> <span style="color: #000000">count1</span><span style="color: #000000; font-weight: bold">[:]</span>       <span style="color: #8f5902; font-style: italic">#empties lists to allow for lists to be reused</span>
                        <span style="color: #204a87; font-weight: bold">del</span> <span style="color: #000000">count2</span><span style="color: #000000; font-weight: bold">[:]</span>
                        <span style="color: #204a87; font-weight: bold">del</span> <span style="color: #000000">chi</span><span style="color: #000000; font-weight: bold">[:]</span>
                    <span style="color: #8f5902; font-style: italic">#signals the for loop to stop    </span>
                    <span style="color: #204a87; font-weight: bold">except</span><span style="color: #000000; font-weight: bold">:</span>
                        <span style="color: #204a87; font-weight: bold">break</span>
                
                <span style="color: #8f5902; font-style: italic">#this starts off the loop at the first pair of nucleotides</span>
                <span style="color: #204a87; font-weight: bold">else</span><span style="color: #000000; font-weight: bold">:</span>                      
                    <span style="color: #204a87; font-weight: bold">print</span> <span style="color: #4e9a06">&quot;PAIR ID: &quot;</span> <span style="color: #ce5c00; font-weight: bold">+</span> <span style="color: #204a87">str</span><span style="color: #000000; font-weight: bold">(</span><span style="color: #000000">x</span><span style="color: #000000; font-weight: bold">)</span> <span style="color: #ce5c00; font-weight: bold">+</span> <span style="color: #4e9a06">&quot; and &quot;</span> <span style="color: #ce5c00; font-weight: bold">+</span> <span style="color: #204a87">str</span><span style="color: #000000; font-weight: bold">(</span><span style="color: #000000">y</span><span style="color: #000000; font-weight: bold">)</span>
                    <span style="color: #000000">split_snp</span><span style="color: #000000; font-weight: bold">(</span><span style="color: #000000">x</span><span style="color: #000000; font-weight: bold">,</span><span style="color: #000000">y</span><span style="color: #000000; font-weight: bold">)</span>
                    <span style="color: #000000">x</span> <span style="color: #ce5c00; font-weight: bold">+=</span> <span style="color: #0000cf; font-weight: bold">2</span>
                    <span style="color: #000000">y</span> <span style="color: #ce5c00; font-weight: bold">+=</span> <span style="color: #0000cf; font-weight: bold">2</span>    
                    <span style="color: #000000">chisq</span><span style="color: #000000; font-weight: bold">()</span>
                    <span style="color: #000000">pvalue</span><span style="color: #000000; font-weight: bold">()</span>
                    <span style="color: #204a87; font-weight: bold">del</span> <span style="color: #000000">count1</span><span style="color: #000000; font-weight: bold">[:]</span>        <span style="color: #8f5902; font-style: italic">#empties lists to allow for lists to be reused</span>
                    <span style="color: #204a87; font-weight: bold">del</span> <span style="color: #000000">count2</span><span style="color: #000000; font-weight: bold">[:]</span>
                    <span style="color: #204a87; font-weight: bold">del</span> <span style="color: #000000">chi</span><span style="color: #000000; font-weight: bold">[:]</span>
    <span style="color: #000000">f</span><span style="color: #ce5c00; font-weight: bold">.</span><span style="color: #000000">close</span><span style="color: #000000; font-weight: bold">()</span>


<span style="color: #000000">to_file</span><span style="color: #ce5c00; font-weight: bold">.</span><span style="color: #000000">write</span><span style="color: #000000; font-weight: bold">(</span><span style="color: #4e9a06">&quot; Count of nucleotides in SNP Pair    ||| &quot;</span><span style="color: #000000; font-weight: bold">)</span>
<span style="color: #000000">to_file</span><span style="color: #ce5c00; font-weight: bold">.</span><span style="color: #000000">write</span><span style="color: #000000; font-weight: bold">(</span><span style="color: #4e9a06">&quot;\t&quot;</span><span style="color: #000000; font-weight: bold">)</span>
<span style="color: #000000">to_file</span><span style="color: #ce5c00; font-weight: bold">.</span><span style="color: #000000">write</span><span style="color: #000000; font-weight: bold">(</span><span style="color: #4e9a06">&quot;P-Value      ||| &quot;</span><span style="color: #000000; font-weight: bold">)</span>
<span style="color: #000000">to_file</span><span style="color: #ce5c00; font-weight: bold">.</span><span style="color: #000000">write</span><span style="color: #000000; font-weight: bold">(</span><span style="color: #4e9a06">&quot;\t&quot;</span><span style="color: #000000; font-weight: bold">)</span>
<span style="color: #000000">to_file</span><span style="color: #ce5c00; font-weight: bold">.</span><span style="color: #000000">write</span><span style="color: #000000; font-weight: bold">(</span><span style="color: #4e9a06">&quot;Chi-Squared Value&quot;</span><span style="color: #000000; font-weight: bold">)</span>
<span style="color: #000000">to_file</span><span style="color: #ce5c00; font-weight: bold">.</span><span style="color: #000000">write</span><span style="color: #000000; font-weight: bold">(</span><span style="color: #4e9a06">&quot;\n\n&quot;</span><span style="color: #000000; font-weight: bold">)</span>

<span style="color: #000000">run</span><span style="color: #000000; font-weight: bold">(</span><span style="color: #0000cf; font-weight: bold">6</span><span style="color: #000000; font-weight: bold">,</span><span style="color: #0000cf; font-weight: bold">7</span><span style="color: #000000; font-weight: bold">)</span>        <span style="color: #8f5902; font-style: italic">#runs the whole program.  </span>
</pre></td></tr></table></div>

