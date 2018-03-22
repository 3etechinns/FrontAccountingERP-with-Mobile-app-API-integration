/****************************************************************************
Author: Tom Hallman
Name: Import Journal Entry/Deposit/Payment
Free software under GNU GPL
*****************************************************************************/

/////////////////
// Installation

1) If you haven't already, unzip the file 'import_journalentry.zip'.
2) In FrontAccounting, choose Setup > Maintenance section (right pane) > 
   Install/Update Modules.
3) Recommended settings for installation:
   - Menu Tab:    Banking and General Ledger
   - Name:        Import Journal Entry/Deposit/Payment
   - Folder:      import_journalentry  (should follow unix folder convention)
   - Module file: import_journalentry.php  (from unzipped module file)
   - Click "Save"

////////////////
// File Format

Currently this module only imports CSV files of the following format:
accountcode,dimension1,dimension2,amount,memo

In this case, the separator is a comma (,) though any separator will work.
For proper use of these fields, see the Journal Entry / Deposit / Payment
transaction entry dialogs within FrontAccounting under Banking and General
Ledger.

Example CSV import file:
accountcode,dimension1,dimension2,amount,memo 
10002,MyDim,,945.59,"My memo"
5600,MyDim2,,-400,""
5602,MyDim2,,-545.59,""

Note 1: Dimensions are expressed in references, not IDs!

Note 2: it is wise to enclose memos in double quotes ("my memo") so that
        it will be parsed properly in case it contains the field separator.

/////////////////////
// Using the Module

Once you have an import file, open this module.  (If you used the defaults,
it will be under Banking and General Ledger toward the bottom right.)

1) Select whether the import file is a Journal Entry, Deposit or Payment.
2) Select the field separator (a comma by default).
3) Select the import file.
4) Click "Perform Import".  This will then load the Journal Entry, Deposit
   or Payment entry dialog, depending on which you selected.
5) Fill in the other fields.
6) Process the Journal Entry, Deposit or Payment.

/////////////
// Language

The language used inside this module does NOT follow the traditional GETTEXT
translations found in most of FrontAccounting.  If you want to translate to
another language, please modify the import file directly.

/////////////////
// Improvements
 
If you make improvements to this module, please share it with the rest of us! 
We will then incorporate it into the module.
