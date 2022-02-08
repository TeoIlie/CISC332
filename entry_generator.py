import math, random, names
from token import EXACT_TOKEN_TYPES


def make_str(str):
    return "'" + str + "'"


def gen_time():
    
    hour = str(random.randint(0,24))
    if len(hour) == 1:
        hour = '0'+hour
    minute = str(random.randint(0,60))
    if len(minute) == 1:
        minute = '0'+minute
    sec = str(random.randint(0,60))
    if len(sec) == 1:
        sec = '0'+sec
    return make_str(hour + ":" + minute + ":" + sec)


def gen_phone_number():
    phone = ''
    numbers = []    
    for i in range(48,58):
        numbers.append(chr(i))

    if random.randint(0,1) == 0:
        phone += '416-'
    else:    
        phone += '613-'
    for i in range(3):
        phone += random.choice(numbers)
    phone += '-'
    for i in range(4):
        phone += random.choice(numbers)
    return make_str(phone)


def gen_credential():
    lst = ['MD', "DO", 'MBBS', 'PhD', 'DNP', 'CNP', 'PA', 'CNS']
    return make_str(lst[random.randrange(len(lst))])


def gen_vax_site():
    lst = ['Etobicoke Site', 'Mississauga Site', 'North York', 'Gerrard Square Mall', 'Yorkdale Mall', 'RevPharma', 'Shoppers Drugmart', 'Rexall']
    return make_str(lst[random.randrange(len(lst))])


def gen_str_name():
    lst = ['Bath road', 'Grand boulevard', 'Gerrard St', 'Dundas St', 'Sunset Blvd', 'Yonge St', 
    'Bloor St', 'Jarvis St', 'Sherbourne St', 'Parliament St']
    return make_str(lst[random.randrange(len(lst))])


def gen_place():
    lst = ['Toronto', 'Mississauga', 'Etobicoke', 'Waterloo', 'Kitchener', 'Kingston', 'Ottawa', 
    'Montreal', 'Vancouver', 'PEI', 'Perth', 'Burlington', 'London', 'Scarborough', 'Ajax']
    return make_str(lst[random.randrange(len(lst))])


def gen_pharma():
    lst = ['Janssen', 'Astra-Zeneca', 'Pfizer', 'Moderna']
    return make_str(lst[random.randrange(len(lst))])


def gen_lot():
    lst = ['CWYSP6ZDAK', 'QB6C2GMF1G', 'PS9F6Y0KYL', 'K07FCPKAN0', '8A62WLWGOR', 'FNPISMJBH6', 'MNQMHWKLCP', '6ZOGKPGR8X']
    return make_str(lst[random.randrange(len(lst))])
    """
    length = 10
    lot = ''

    options = []
    for i in range(48,58):
        options.append(chr(i))
    for i in range(65, 91):
        options.append(chr(i))

    for i in range(length):
        lot += random.choice(options)
        

    return make_str(lot)
    """


def gen_patient_ohip():
    lst = ['LG7J3Q0BOE', 'JOH8UA793E', 'DOUPAVQT60', 'TKJDHWSOU1', 'ET7WFLVS2T', 'V78BG60XNJ', '9QSY8Q852F', 'GUKS7UCG70']
    return make_str(lst[random.randrange(len(lst))])


def gen_doctor_id():
    lst = ['ODAEEGA5IC', '4LLWJ1BOEU', 'SBKDJQZOTE', '76J85OBC25', 'H6YMTOYGLX', 'LC8LEEKAB6', 'OANAK08QFD', '4K3XJDXXCY']
    return make_str(lst[random.randrange(len(lst))])


def gen_nurse_id():
    lst = ['UI340N0BK0', 'SDML7NCTYY', 'J6FUYVDIJA', 'PPXDINET6K', 'ZSJ7WW1ZJH', 'MGSQO1A52L', 'YKLSIF9GOG', '91MZHF69N9']
    return make_str(lst[random.randrange(len(lst))])


def gen_postal():
    code = ''
    letters = []
    for i in range(65, 91):
        letters.append(chr(i))
    numbers = []    
    for i in range(48,58):
        numbers.append(chr(i))
    code += random.choice(letters) + random.choice(numbers) + random.choice(letters)
    code += " "
    code += random.choice(numbers) + random.choice(letters) + random.choice(numbers)
    return make_str(code)


def gen_fst_name():
    name = names.get_full_name()
    name = name.split(" ")
    return make_str(name[0])


def gen_lst_name():
    name = names.get_full_name()
    name = name.split(" ")
    return make_str(name[1])


def gen_date(start_year, end_year):

    year = random.randint(start_year, end_year)
    month = random.randint(1,12)
    day = random.randint(1,31)

    year = str(year)

    if month < 10:
        month = "0" + str(month)
    else:
        month = str(month)

    if day < 10:
        day = "0" + str(day)
    else:
        day = str(day)

    return make_str(year + "-" + month + "-" + day)


def gen_vax_lots():
    entries = ''
    for i in range(8):
        line = "(" + gen_lot() + ", " + str(random.randint(0,2)) + ", " + gen_date(2019,2022) + ", " + gen_date(2022,2025) + ", " + gen_pharma() + ", " + gen_vax_site() + "),\n"
        entries += line
    return entries[:-2] + ';'


def gen_lst_vax_sites():
    entries = ''
    for i in range(8):
        line = "(" + gen_vax_site() +", "+ str(random.randint(1,10000)) +", "+ gen_str_name() +", "+ gen_postal() +", "+ gen_place() +"),\n"
        entries += line
    return entries[:-2] + ';'

def gen_patients():
    entries = ''
    for i in range(8):
        line = "("+gen_fst_name()+", "+gen_lst_name()+", "+gen_lot()+", "+gen_date(1900,2010)+"),\n"
        entries += line
    return entries[:-2] + ';'


def gen_doctors():
    entries = ''
    for i in range(8):
        line = "("+gen_lot()+", "+gen_fst_name()+", "+gen_lst_name()+"),\n"
        entries += line
    return entries[:-2] + ';'


def gen_spouses():
    entries = ''
    for i in range(8):
        line = "("+gen_phone_number()+", "+gen_lot()+", "+gen_fst_name()+", "+gen_lst_name()+", "+gen_patient_ohip()+"),\n"
        entries += line
    return entries[:-2] + ';'

def gen_medical_practice():
    name = ['Universal Health', 'Revolution Health', 'Rejuvenate', 'Encounter', 'Big Smiles', 'Health4All', 'Joyful Health', 'Queen\'s Health']
    entries = ''
    for i in range(8):
        line = "("+gen_phone_number()+", "+make_str(name[i])+", "+gen_doctor_id()+ "),\n"
        entries += line
    return entries[:-2] + ';'


def gen_nurse_staffs():
    entries = ''
    for i in range(8):
        line = "("+gen_nurse_id()+", "+gen_vax_site() + "),\n"
        entries += line
    return entries[:-2] + ';'


def gen_doctor_staffs():
    entries = ''
    for i in range(8):
        line = "("+gen_doctor_id()+", "+gen_vax_site() + "),\n"
        entries += line
    return entries[:-2] + ';'


def gen_operating_dates():
    entries = ''
    for i in range(8):
        line = "("+gen_date(2020,2022)+", "+gen_vax_site() + "),\n"
        entries += line
    return entries[:-2] + ';'


def gen_nurse_credentials():
    entries = ''
    for i in range(8):
        line = "("+gen_credential()+", "+gen_nurse_id()+ "),\n"
        entries += line
    return entries[:-2] + ';'


def gen_recieve_vaccine():
    entries = ''
    for i in range(8):
        line = "("+gen_lot() + ", "+gen_vax_site()+", "+gen_patient_ohip()+", "+gen_date(2020,2022)+", "+gen_time()+ "),\n"
        entries += line
    return entries[:-2] + ';'

def main():
    print(gen_recieve_vaccine())
    

main()
