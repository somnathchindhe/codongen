import argparse
from itertools import product

def generate_sequences(input_sequence):
    synonymous_codons = {
    'ATT': ['ATT', 'ATC', 'ATA'],
    'ATC': ['ATC', 'ATT', 'ATA'],
    'ATA': ['ATA', 'ATC', 'ATT'],
    'CTT': ['CTT', 'CTC', 'CTA', 'CTG', 'TTA', 'TTG'],
    'CTC': ['CTC', 'CTT', 'CTA', 'CTG', 'TTA', 'TTG'],
    'CTA': ['CTA', 'CTC', 'CTT', 'CTG', 'TTA', 'TTG'],
    'CTG': ['CTG', 'CTC', 'CTA', 'CTT', 'TTA', 'TTG'],
    'TTA': ['TTA', 'CTC', 'CTA', 'CTG', 'CTT', 'TTG'],
    'TTG': ['TTG', 'CTC', 'CTA', 'CTG', 'TTA', 'CTT'],
    'GTT': ['GTT', 'GTC', 'GTA', 'GTG'],
    'GTC': ['GTC', 'GTT', 'GTA', 'GTG'],
    'GTA': ['GTA', 'GTC', 'GTT', 'GTG'],
    'GTG': ['GTG', 'GTC', 'GTA', 'GTT'],
    'TTT': ['TTT', 'TTC'],
    'TTC': ['TTC', 'TTT'],
    'ATG': ['ATG'],
    'TGT': ['TGT', 'TGC'],
    'TGC': ['TGC', 'TGT'],
    'GCT': ['GCT', 'GCC', 'GCA', 'GCG'],
    'GCC': ['GCC', 'GCT', 'GCA', 'GCG'],
    'GCA': ['GCA', 'GCC', 'GCT', 'GCG'],
    'GCG': ['GCG', 'GCC', 'GCA', 'GCT'],
    'GGT': ['GGT', 'GGC', 'GGA', 'GGG'],
    'GGC': ['GGC', 'GGT', 'GGA', 'GGG'],
    'GGA': ['GGA', 'GGC', 'GGT', 'GGG'],
    'GGG': ['GGG', 'GGC', 'GGA', 'GGT'],
    'CCT': ['CCT', 'CCC', 'CCA', 'CCG'],
    'CCC': ['CCC', 'CCT', 'CCA', 'CCG'],
    'CCA': ['CCA', 'CCC', 'CCT', 'CCG'],
    'CCG': ['CCG', 'CCC', 'CCA', 'CCT'],
    'ACT': ['ACT', 'ACC', 'ACA', 'ACG'],
    'ACC': ['ACC', 'ACT', 'ACA', 'ACG'],
    'ACA': ['ACA', 'ACC', 'ACT', 'ACG'],
    'ACG': ['ACG', 'ACC', 'ACA', 'ACT'],
    'TCT': ['TCT', 'TCC', 'TCA', 'TCG', 'AGT', 'AGC'],
    'TCC': ['TCC', 'TCT', 'TCA', 'TCG', 'AGT', 'AGC'],
    'TCA': ['TCA', 'TCC', 'TCT', 'TCG', 'AGT', 'AGC'],
    'TCG': ['TCG', 'TCC', 'TCA', 'TCT', 'AGT', 'AGC'],
    'AGT': ['AGT', 'TCC', 'TCA', 'TCG', 'TCT', 'AGC'],
    'AGC': ['AGC', 'TCC', 'TCA', 'TCG', 'AGT', 'TCT'],
    'TAT': ['TAT', 'TAC'],
    'TAC': ['TAC', 'TAT'],
    'TGG': ['TGG'],
    'CAA': ['CAA', 'CAG'],
    'CAG': ['CAG', 'CAA'],
    'AAT': ['AAT', 'AAC'],
    'AAC': ['AAC', 'AAT'],
    'CAT': ['CAT', 'CAC'],
    'CAC': ['CAC', 'CAT'],
    'GAA': ['GAA', 'GAG'],
    'GAG': ['GAG', 'GAA'],
    'GAT': ['GAT', 'GAC'],
    'GAC': ['GAC', 'GAT'],
    'AAA': ['AAA', 'AAG'],
    'AAG': ['AAG', 'AAA'],
    'CGT': ['CGT', 'CGC', 'CGA', 'CGG', 'AGA', 'AGG'],
    'CGC': ['CGC', 'CGT', 'CGA', 'CGG', 'AGA', 'AGG'],
    'CGA': ['CGA', 'CGC', 'CGT', 'CGG', 'AGA', 'AGG'],
    'CGG': ['CGG', 'CGC', 'CGA', 'CGT', 'AGA', 'AGG'],
    'AGA': ['AGA', 'CGC', 'CGA', 'CGG', 'CGT', 'AGG'],
    'AGG': ['AGG', 'CGC', 'CGA', 'CGG', 'AGA', 'CGT'],
    'TAA': ['TAA', 'TAG', 'TGA'],
    'TAG': ['TAA', 'TAG', 'TGA'],
    'TGA': ['TAA', 'TAG', 'TGA']
}


    # Split the sequence into codons
    codons = [input_sequence[i:i+3] for i in range(0, len(input_sequence), 3)]

    # Generate all possible combinations of synonymous codons
    try:
        possible_combinations = product(*(synonymous_codons[codon] for codon in codons))
        # Print all sequences
        for combo in possible_combinations:
            new_sequence = ''.join(combo)
            print(f"{new_sequence}")
    except KeyError as e:
        print(f"Error: Codon {e} not found in synonymous codons dictionary.")

if __name__ == "__main__":
    parser = argparse.ArgumentParser(description='Generate synonymous codon sequences.')
    parser.add_argument('-seq', dest='sequence', type=str, help='Input sequence')

    args = parser.parse_args()
    if args.sequence:
        generate_sequences(args.sequence)
    else:
        print("Please provide a sequence using the '-seq' argument.")
