#!/bin/bash

# List of files to check and delete
files=("temp_codon_usage" "sorted_all_output.tsv" "sorted_all_output_gc.tsv" "total_output_sample_data_mrna1.csv")

# Iterate through the files
for file in "${files[@]}"; do
    if [ -f "$file" ]; then
        rm "$file"
        echo "$file is removed"
    fi
done


python3 NEW_ARG_SCRIPT.PY -seq $1 > "$2"_temp_codon_usage
python3 calculate2.py "$2"_temp_codon_usage $2 >"$2"_temp_ecoli_codon_usage
#cat  temp_ecoli_codon_usage
rm "$2"_temp_ecoli_codon_usage
rm "$2"_temp_codon_usage

#EXTRACT COLOUMN FROM OUTPUT TSV FILE AND THEN CONVERT IT INTO FASTA TEMP. FILE AND
#for i in `cat sorted_all_output.tav

file="$2_sorted_all_output.tsv"

# Check if the file exists
if [ ! -f "$file" ]; then
    echo "File not found: $file"
    exit 1
fi

# Read the file line by line
while IFS=$'\t' read -r a b c rest_of_line; do
    # Process the values as needed
    #echo "a: $a, b: $b, c: $c"
    
gc=$(echo $b | awk '!/^>/{gc+=gsub(/[gGcC]/,""); at+=gsub(/[aAtT]/,"");} END{ printf "%.2f%%\n", (gc*100)/(gc+at) }' | sed 's/%//g' )
#echo $gc
#echo "$a,$b,$c,$gc" >> $2_sorted_all_output_gc.tsv #this file contain gc contant 
seq=$(echo "$b" | sed 's/T/U/g')
#echo $seq
# write code to calculate free energy of enseble
#!/bin/bash

# Your RNA sequence
#rna_sequence="AUGGCGUCACUGUAGCUCUUAUCCCAUAGUGUCUGCCGUUGAUAUUUACUUGGGUUCGAUGGUCAGCGUAGCGUGGGAGGAAUACCCCGUUGUUCACACUU"

#echo "CTACGGCGCGGCGCCCTTGGCGA" | RNAfold 
#seq=CUACGGCGCGGCGCCCUUGGCGA
#...........((((...)))). ( -5.00)

# Run RNAfold to calculate the free energy and predict secondary structure
#output=$(echo "$seq" | RNAfold --noPS)
output=$(echo "$seq" | RNAfold)

##cp -r rna.ps "$a"_"$2"_rna.ps #please uncomment if you want genrate rnafold strcture

# Extracting the free energy from the output
mfe=$(echo "$output" | awk '{print $NF}' | tr -d '()'| sed -n '2p')
# mv "$a"_"$2"_rna.ps rna_ps_str/    #please uncomment if you want genrate rnafold strcture
#a b c r
# Display the results
#echo "RNA Sequence: $rna_sequence"
#echo "Predicted Secondary Structure: $output"
#mfe=$(echo $free_energy ||sed 's/ /\t/g'| cut -f2)
#echo $free_energy >>sample_t 
if [ -f “$2_total_output_sample_data_mrna1.csv” ]; then
rm "$2_total_output_sample_data_mrna.csv"
#echo "$filename is removed"
fi

echo "$a,$b,$seq,$c,$gc,$mfe" >> $2_total_output_sample_data_mrna1.csv
echo $'Seq_ID,Syno_DNA_sequence,Syno_RNA_sequence,CU_Score,GC%,MFE' | cat - $2_total_output_sample_data_mrna1.csv > $2_total_output_sample_data_mrna.csv
#rm total_output_sample_data_mrna1.csv
done < "$file"
rm "$file"
mv $2_total_output_sample_data_mrna.csv results/$2_total_output_sample_data_mrna.csv
rm $2_total_output_sample_data_mrna1.csv
