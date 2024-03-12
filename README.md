This tool is designed to help you to find optimal synonymous DNA sequences to express in E.coli, based on codon usage, GC content, and mRNA fold energy values.
To run this code:
bash alternate_4.sh <DNA seqeunce file in fasta format> <job id>
Tool Illustration
Codon usage score:
This score is a measure of how frequently a particular codon is used in E.coli. This score calculated using codon usage frequency of each codon per thousand Nucleotides in Escherichia coli.

GC Content Score:
This score is a measure of the percentage of guanine (G) and cytosine (C) nucleotides in a DNA sequence. G and C nucleotides form three hydrogen bonds, while adenine (A) and thymine (T) nucleotides form two hydrogen bonds. As a result, DNA sequences with higher GC content are typically more stable.

RNA structure:
The structure of an RNA molecule is important for its function. RNA molecules that fold into stable structures are less likely to function properly. It uses Vienna RNAfold package to calculate free energy (kcal/mol-1) of RNA ensemble. If mRNA structure is more unstable, it is likely to translate fast.

The tool works by taking a DNA sequence as input and then estimating the values of these three parameters for the sequence and gives table output.
You can then use this information to select sequences that are likely to be optimally translated in Escherichia coli
