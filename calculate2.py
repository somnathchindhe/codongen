import argparse

# Create an ArgumentParser object
parser = argparse.ArgumentParser(description='Description of your script')

# Add arguments
parser.add_argument('name', type=str, help='File path or name')
parser.add_argument('number', type=str)

# Parse the arguments
args = parser.parse_args()

file_path = args.name  # Argument for file path or name
id = args.number  # Argument for the number of sequences to display

#create a dictionary using the given codon usage values per thousand codons and then create a function to rank sequences based on the sum of codon values within those sequences.
codon_usage = {
    'GGG': 8.59, 'GGA': 9.18, 'GGT': 21.28, 'GGC': 33.39,
    'GAG': 18.35, 'GAA': 43.73, 'GAT': 37.88, 'GAC': 20.50,
    'GTG': 26.36, 'GTA': 11.52, 'GTT': 16.79, 'GTC': 11.71,
    'GCG': 38.46, 'GCA': 21.09, 'GCT': 10.74, 'GCC': 31.63,
    'AGG': 1.56, 'AGA': 1.37, 'AGT': 7.22, 'AGC': 16.60,
    'AAG': 12.10, 'AAA': 33.19, 'AAT': 21.87, 'AAC': 24.40,
    'ATG': 24.80, 'ATA': 3.71, 'ATT': 30.46, 'ATC': 18.16,
    'ACG': 11.52, 'ACA': 6.44, 'ACT': 8.00, 'ACC': 22.84,
    'TGG': 10.74, 'TGA': 0.98, 'TGT': 5.86, 'TGC': 8.00,
    'TAG': 0.00, 'TAA': 1.76, 'TAT': 16.79, 'TAC': 14.64,
    'TTG': 11.91, 'TTA': 15.23, 'TTT': 19.72, 'TTC': 15.03,
    'TCG': 8.00, 'TCA': 7.81, 'TCT': 5.66, 'TCC': 5.47,
    'CGG': 4.10, 'CGA': 4.30, 'CGT': 21.09, 'CGC': 25.97,
    'CAG': 27.72, 'CAA': 12.10, 'CAT': 15.81, 'CAC': 13.08,
    'CTG': 46.86, 'CTA': 5.27, 'CTT': 11.91, 'CTC': 10.54,
    'CCG': 26.75, 'CCA': 6.64, 'CCT': 8.40, 'CCC': 6.44
}


def calculate_sequence_score(sequence, codon_usage):
    score = 0.0
    for i in range(0, len(sequence), 3):
        codon = sequence[i:i + 3]
        if codon in codon_usage:
            score += codon_usage[codon]
    return score

#file_path = 'name'  # 1st argument
with open(file_path, 'r') as file:
    sequences = file.read().splitlines()

sequence_scores = []
for sequence in sequences:
    score = calculate_sequence_score(sequence, codon_usage)
    sequence_scores.append((sequence, score))

# Sort sequences based on scores
sorted_sequences = sorted(sequence_scores, key=lambda x: x[1], reverse=True)
# sort sequences based of all
output_file = f"{id}_sorted_all_output.tsv"
#output_file2 = f"{id}_sorted_output.tsv"

# Display all sorted sequences and save to TSV file
with open(output_file, 'w') as f:
    for idx, (sequence, score) in enumerate(sorted_sequences, start=1):
        print(f"{idx}\t{sequence}\t{score}", file=f)

# Display top desired sequences with the highest scores
#top_20_sequences = sorted_sequences[:number]  #second argumant
#for idx, (sequence, score) in enumerate(top_20_sequences, start=1):
#print(f"{idx}\t{sequence}\t{score}")
# print(f"{idx}\t{sequence}\t{score}")

