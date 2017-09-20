#!/usr/bin/env python3

from tf.fabric import Fabric
import csv
import re

VERB_STARTID=13
ROOT_STARTID=2

STEMS = {
    'qal':  'Qal',
    'hif':  'Hiphil',
    'piel': 'Piel',
    'nif':  'Niphal',
    'hit':  'Hitpael',
    'pual': 'Pual',
    'hof':  'Hophal'
    }

TENSES = {
    'perf': 'perfect',
    'impf': 'imperfect',
    #'wayq': 'wayyiqtol',
    'ptca': 'participle active',
    'infc': 'infinitive construct',
    'impv': 'imperative',
    'ptcp': 'participle passive',
    'infa': 'infinitive absolute'
    }

PERSONS = {'p1': 1, 'p2': 2, 'p3': 3, 'unknown': None}
GENDERS = {'m': 'm', 'f': 'f', 'unkown': None}
NUMBERS = {'sg': 's', 'pl': 'p', 'unknown': None}

class Root:
    def __init__(self, n):
        self.lex = F.lex_utf8.v(n)

    def __eq__(self, other):
        return self.lex == other.lex

    def __hash__(self):
        return hash(self.lex)

class Verb:
    def __init__(self, n):
        self.n = n
        verb = F.g_word_utf8.v(n)
        if verb is None or '\u05c3' in verb or '\u05be' in verb:
            raise ValueError('no text, sof pasuq or maqaf')
        # strip accents
        self.verb = re.sub(r'[^\u05b0-\u05bc\u05c1\u05c2\u05c7-\u05ea]', '', verb)
        self.root = F.lex_utf8.v(n)
        self.stem = STEMS[F.vs.v(n)]
        self.tense = TENSES[F.vt.v(n)]
        self.person = PERSONS[F.ps.v(n)]
        self.gender = GENDERS[F.gn.v(n)]
        self.number = NUMBERS[F.nu.v(n)]
        self.loc = T.sectionFromNode(n)

    def unpointed_word(self):
        return re.sub(r'[^\u05d0-\u05ea]', '', self.verb)

    def __eq__(self, other):
        return self.unpointed_word() == other.unpointed_word() and \
                self.root == other.root and \
                self.stem == other.stem and \
                self.tense == other.tense and \
                self.person == other.person and \
                self.gender == other.gender and \
                self.number == other.number

    def __hash__(self):
        return hash((self.unpointed_word(), self.root, self.stem, self.tense,
                     self.person, self.gender, self.number))

class Databank:
    def __init__(self):
        self.verbs = set()
        self.roots = set()

    def add_root(self, root):
        self.roots.add(root)

    def add_verb(self, verb):
        self.verbs.add(verb)

def handle(n, data):
    if F.language.v(n) != 'hbo': # Ancient Hebrew
        return
    data.add_verb(Verb(n))
    data.add_root(Root(n))

def main():
    TF = Fabric(
        modules=['hebrew/etcbc4c'],
        locations='~/VersionControl/etcbc-data',
        silent=True)
    api = TF.load('language g_word_utf8 lex_utf8 vs vt gn nu ps', silent=True)
    api.makeAvailableIn(globals())

    data = Databank()

    for n in N():
        try:
            handle(n, data)
        except (KeyError, ValueError):
            pass

    print(len(data.verbs), len(data.roots))

    with open('etcbc-verbs.csv', 'w') as csvverbs:
        verbwr = csv.writer(csvverbs, quoting=csv.QUOTE_MINIMAL)
        #verbwr.writerow(['id', 'verb','root','stem','tense','person','gender','number','active'])
        i = VERB_STARTID
        for verb in data.verbs:
            verbwr.writerow([
                i,
                verb.verb,
                verb.root,
                verb.stem,
                verb.tense,
                verb.person if verb.person is not None else 'NULL',
                verb.gender if verb.gender is not None else 'NULL',
                verb.number if verb.number is not None else 'NULL',
                1
                ])
            i += 1

    with open('etcbc-roots.csv', 'w') as csvroots:
        rootwr = csv.writer(csvroots, quoting=csv.QUOTE_MINIMAL)
        #rootwr.writerow(['id', 'root', 'root_kind_id'])
        i = ROOT_STARTID
        for root in data.roots:
            rootwr.writerow([i, root.lex, 1])
            i += 1


if __name__ == '__main__':
    main()
