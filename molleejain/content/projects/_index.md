---
title: "Projects"
date: 2020-07-24T08:47:11+01:00
draft: false
css: default-css.css
---

My interests and experiences so far have been pretty varied and fulfilling! I'm always looking to learn more. Below you'll find a few of the projects I've worked on. 

## Microsoft
I joined the Azure Data group at Microsoft in the fall of 2016 as a new college hire and have worked within SQL Server and Azure Open Source Databases (OSS) Services. Here are a few of the public tools and features I've worked on!

<!-- dea -->
{{% project-expand "Database Experimentation Assistant" %}}
---
> Database Experimentation Assistant (DEA) is an experimentation solution for SQL Server upgrades. DEA can help you evaluate a targeted version of SQL Server for a specific workload. Customers upgrading from earlier versions of SQL Server (starting with 2005) to more recent versions of SQL Server can use the analysis metrics that the tool provides. 

To learn more, check out the [documentation](https://docs.microsoft.com/en-us/sql/dea/database-experimentation-assistant-overview?view=sql-server-ver15) here. 

![dea-report](/images/dea-report.png)
{{% /project-expand %}}  

<!--  horizontal break -->
---  

<!-- query performance insight -->
{{% project-expand "Intelligent Performance" %}}
---
  
As part of Azure's Open Source Database Services offerings, a customer has the opportunity to monitor and tune their relational database using intelligent performance offerings, including Query Performance Insights and Performance Recommendations.

To learn more, check out the [documentation](https://docs.microsoft.com/en-us/azure/mysql/concepts-query-store) or watch the [Microsoft Ignite session](https://myignite.techcommunity.microsoft.com/sessions/81012).

![qpi-overview](/images/qpi-overview.png)
{{% /project-expand %}}

<!--  horizontal break -->
---


## Undergraduate Projects
I studied computer science (and biology!) at Wellesley College.  During my time as an undergraduate, I was able to work on a few projects, both in the classroom and over different internships.

<!-- CS307 -->
{{% project-expand "Computer Graphics" "Fall 2014" %}}
---

For a detailed description and live demo of this project, check out [this](https://cdn.rawgit.com/mjain2/cs307-graphics/master/project.html) page.

Screenshots of my final graphics project are below.

![cs307-final](/images/cs307final.png)

{{% /project-expand %}}  

<!--  horizontal break -->
---  


<!-- Commenting out the CS230 project now as it is not super relevant -->
<!-- CS230
{{% project-expand "'Which Dorm is Your Dorm?'" "Spring 2014" %}}
---

CS230, Wellesley's data structures course, explored topics in data abstration, modularity, and performance optimization. As part of our final project, my group and I implemented a "Buzzfeed"-esque quiz to determine which Wellesley College dorm best fits your personality.

One way of taking the quiz was to answer a series of questions at the end of which an ideal dorm matching your responses would be presented. Another method of determining your ideal dorm is through simply checking the qualities in a dorm that are important to you.We primarily used decision trees and hashtables to run this quiz. The quiz can be taken both in the console and in a GUI in Java, a screenshot of which is shown below.

![cs230-final](/images/cs230final.png)

{{% /project-expand %}}  

-->

<!-- CS249 -->
{{% project-expand "Computing and Life" "Spring 2014" %}}
---

This course explored the areas of bioinformatics, computational genomics, and modeling/simulating aspects of life. As part of my final project, I had to use an existing model on NetLogo and modify it for my own use. I was interested explaining how the immune system reacts to the presence of a pathogen (ie. learned responses vs initial exposures to pathogens) and decided to show a model of how the immune system fights pathogens. For an added level of complexity, I added in the factor of evolving pathogens and shifted my model to also deal with the evolving pathogens.

A screenshot of the final model can be seen below.

![cs249-final](/images/cs249final.png)

As part of my model, I included different types of pathogens (ie. Influenza A pathogens) with varying strength and mortality rates. I added in a variable to account for a pathogen that attacks the immune system and another variable to account for if a vaccine is available for the vaccine. These presets were automatically set based on which pathogen was selected. Another dynamic variable was the count of pathogens present in your system before simulating the model. A graph at the bottom would display the counts of white blood cells vs pathogen cells.

{{% /project-expand %}}  

<!--  horizontal break -->
---  

<!-- STSI -->
{{% project-expand "Novoalign & Chi Squared Analysis of GWAS tests" "Summer 2013" %}}
---

Through the course of a summer at the Scripps Translational Science Intitute, I was able to work on a some personal and team projects. The wesbite I launched that summer details the work I did and can be found [here](stsi/stsi.html).

One of my large scale projects for that summer was to create a chi-squared test in Python to apply to GWAS (or Genome Wide Association Study). A GWAS is useful genomically because it tests a 'control' genome (for us, HG19) with a 'variable' genome to determine where the differences, or single-nucleotide polymorphisms (SNPs), occured. Since a GWAS determines if the allelic frequency between genomes is different, I added code to determine if this difference in allelic frequency between genomes is significant. If signifcant, then the SNP locations in the 'variable' genome could tell us something about diseases and illnesses, like cancer (the primary research area of our lab).

{{% /project-expand %}}  

<!--  horizontal break -->
---  






