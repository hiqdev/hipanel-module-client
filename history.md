# hiqdev/hipanel-module-client

## [Under development]

    - [ac8cbb7] 2017-06-20 renamed `web` config <- hisite [@hiqsol]
    - [ff3c56f] 2017-06-20 renamed `hidev.yml` [@hiqsol]
    - [2820494] 2017-06-09 Merge pull request #18 from bladeroot/client-formatter-field [@hiqsol]
    - [ace63d1] 2017-06-09 remove isOperable, remove skipCheckOperable [@BladeRoot]
    - [435e68d] 2017-06-09 fixes [@BladeRoot]
    - [8b04a41] 2017-06-09 + isOperable [@BladeRoot]
    - [48a9467] 2017-06-09 + translatin [@BladeRoot]
    - [1c681da] 2017-06-09 replace delete action to ClientDetailMenu.php; use CSS for modal header [@BladeRoot]
    - [5441604] 2017-06-06 + formatter field; remove use [@BladeRoot]
    - [add942d] 2017-06-01 Merge pull request #17 from bladeroot/client-isolated-view-bulk-operation [@hiqsol]
    - [b824971] 2017-06-01 to camelCase [@BladeRoot]
    - [42612dc] 2017-06-01 to camelCase [@BladeRoot]
    - [53ff314] 2017-06-01 moe bulk op to isolated views [@BladeRoot]
    - [c506864] 2017-05-30 disabled required fields for managers in Contact [@hiqsol]
    - [1f5f84c] 2017-05-30 disabling required fields for managers in Contact [@hiqsol]
    - [88f778f] 2017-05-19 Merge pull request #16 from bladeroot/client-bulk-operation [@hiqsol]
    - [959ad55] 2017-05-18 remove body from modal [@BladeRoot]
    - [2218115] 2017-05-18 use bulk operation widget for same operation [@BladeRoot]
    - [4b1828b] 2017-05-15 Fixing sotered login_like in ClientController [@tafid]
    - [da397d5] 2017-05-15 Added info to Pincode settings [@tafid]
    - [3413638] 2017-05-04 Allow passing limit through ContactSearch [@SilverFire]
    - [2929f35] 2017-05-03 Merge pull request #15 from bladeroot/client-seller-partner [@SilverFire]
    - [994eefe] 2017-05-03 + partner to seller filter [@BladeRoot]
    - [14b8876] 2017-04-13 Changed icon for two factor authorization from shield to lock [@tafid]
    - [cede170] 2017-04-13 Added ClientRelationFreeStub [@SilverFire]
    - [03f1c23] 2017-04-12 Fixed save representation view [@tafid]
    - [1ce4335] 2017-04-12 Removed set-orientation action [@tafid]
    - [f87da65] 2017-04-10 fixed redirect in client/index [@hiqsol]
    - [ccd037a] 2017-04-03 Changed contact edit: always ask for pincode when user is privileged [@SilverFire]
    - [9c7c274] 2017-03-31 Added submit button to bottom of form [@tafid]
    - [e7681df] 2017-03-23 Merge pull request #12 from bladeroot/client-disable-delete-itself [@hiqsol]
    - [6a1bb71] 2017-03-22 Merge branch 'bladeroot-client-show-verified' [@SilverFire]
    - [27e80f8] 2017-03-22 Code style fixed [@SilverFire]
    - [f986751] 2017-03-13 show old verified info if field not confirmed [@BladeRoot]
    - [119a93a] 2017-03-22 Refactored pincode prompting for contacts [@SilverFire]
    - [2d26780] 2017-03-21 fix contact delete [@BladeRoot]
    - [db6288a] 2017-03-21 disable deleting itself [@BladeRoot]
    - [4845175] 2017-03-17 added setBankDetails trigger [@hiqsol]
    - [3da216d] 2017-03-16 Fixed pincode prompt dialog [@SilverFire]
    - [7033e92] 2017-03-16 added/merged bank details rendering [@hiqsol]
    - [ce28410] 2017-03-16 added bank details rendering in Contact model [@hiqsol]
    - [151b5f2] 2017-03-10 Added contract information management to the Employee form [@SilverFire]
    - [944c23d] 2017-03-08 Implemented employee card [@SilverFire]
    - [44afcf9] 2017-03-06 changed for case insensitive `ilike` filtering in Client where appropriate [@hiqsol]
    - [25a0e71] 2017-02-28 reorganized input fields for contact details [@hiqsol]
    - [123e089] 2017-02-24 added more bank info to contact: bank_account/name/addres/swift [@hiqsol]
    - [8e16cb4] 2017-02-22 simplified getting contact in actionAttachDocuments [@hiqsol]
    - [af258c3] 2017-02-22 Removed `cancel` button from `contact/attach-documents` [@SilverFire]
    - [27375e2] 2017-02-21 fixed client view action query: getting purse documents [@hiqsol]
    - [84175b5] 2017-02-20 csfixed [@hiqsol]
    - [62910f9] 2017-02-17 renamed view purse/_client-view <- bill/_purseBlock [@hiqsol]
    - [abf2712] 2017-02-20 removed use of `hipanel\grid\DataColumn` in favour of `hiqdev\higrid\DataColumn` [@hiqsol]
    - [d4c5c67] 2017-02-15 ContactController - updated search action to use ComboSearchAction [@SilverFire]
    - [1fb4722] 2017-02-14 added requisites representation in contacts [@hiqsol]
    - [866686a] 2017-02-14 added `Contact::renderAddress()` [@hiqsol]
    - [d54a8dd] 2017-02-10 Updated widgets and views to follow yii2-combo API changes [@SilverFire]
    - [895038d] 2017-02-10 added employee client type [@hiqsol]
    - [5f156fb] 2017-02-10 removed organization extraAttribute from name column in Contact grid [@hiqsol]
    - [d0effe9] 2017-02-10 Merge pull request #8 from bladeroot/client-multiview [@hiqsol]
    - [437c09f] 2017-02-10 multiview init [@BladeRoot]
    - [4d8677e] 2017-02-07 allowed view deleted client for managers [@hiqsol]
    - [63c2011] 2017-02-01 Merge pull request #7 from bladeroot/hide-verivication-block [@SilverFire]
    - [ca2d2d0] 2017-02-01 Updated translations, minor [@SilverFire]
    - [465e746] 2017-02-01 hide verification block if client is owner of object [@BladeRoot]
    - [d08074f] 2017-01-31 renamed scenarioActions <- scenarioCommands [@hiqsol]
    - [01d5170] 2017-01-31 changed requirement for hiqdev/yii2-asset-flag-icon-css [@hiqsol]
    - [813cef2] 2017-01-30 renamed hiqdev\\hiart\\ResponseErrorException <- ErrorResponseException [@hiqsol]
    - [6641aeb] 2017-01-30 removed use of ApiConnectionInterface [@hiqsol]
    - [5d2fa3a] 2017-01-27 renamed from -> `tableName` in ActiveRecord [@hiqsol]
    - [f43687e] 2017-01-27 changed index/type -> `from` in ActiveRecord [@hiqsol]
    - [588643d] 2017-01-27 Translations updated [@SilverFire]
    - [b463d48] 2017-01-24 fixed hiart `perform()` usage [@hiqsol]
    - [d388957] 2017-01-24 changed PhoneConfirmer to use Contact model [@hiqsol]
    - [b92f2ed] 2017-01-23 Added pre_ordered_servers_count displaying [@SilverFire]
    - [262c399] 2017-01-19 Merge pull request #4 from bladeroot/fix-client-autocomplet [@SilverFire]
    - [4f9408f] 2017-01-19 fix client autocomplete in email and password [@BladeRoot]
    - [f18faf8] 2017-01-18 Refactored contact and client verification, dropped unused mailing controller and models [@SilverFire]
    - [5136cf7] 2017-01-09 Merge pull request #3 from bladeroot/contact-verification [@hiqsol]
    - [f29b172] 2017-01-07 * fix doube $ on variable [@BladeRoot]
    - [1998768] 2017-01-07 - remove unused class variable; change code structure [@BladeRoot]
    - [776673f] 2017-01-07 + comma after last array element; + descrition of variable [@BladeRoot]
    - [579de2b] 2017-01-07 - remove empty lines [@BladeRoot]
    - [97eb4a2] 2017-01-07 add comma after last array element [@BladeRoot]
    - [a2b18dc] 2017-01-06 changed icon for two factor auth to fa-shield [@hiqsol]
    - [ed36c51] 2017-01-06 + two factor authorization enabling/disabling link in user profile [@hiqsol]
    - [931e7b8] 2017-01-06 * use ForceVerificationBlock widget [@BladeRoot]
    - [61f5469] 2017-01-06 + force verification widget [@BladeRoot]
    - [1cc1599] 2017-01-06 + submitUrl, title [@BladeRoot]
    - [0939aaa] 2017-01-05 added force verification block on client details page [@BladeRoot]
    - [089970b] 2017-01-04 Fixed ClientColumn::init() to allow filter disabling [@SilverFire]
    - [2eb1cef] 2016-12-30 Added name, email, address verification indicators [@SilverFire]
    - [879baac] 2016-12-27 Refactored ClientColumn [@SilverFire]
    - [30cb9a2] 2016-12-27 Use contact.force-verify permission [@SilverFire]
    - [8849a96] 2016-12-26 Removed code auto-requesting for phone confirmation. Added fax confirmation [@SilverFire]
    - [542dc6f] 2016-12-26 Fixed regression in ClientColumn [@SilverFire]
    - [2ae0d57] 2016-12-26 Updated translations [@SilverFire]
    - [6dff676] 2016-12-26 Translations updated [@SilverFire]
    - [a8e88f6] 2016-12-23 Implemented contact phone confirmation [@SilverFire]
    - [80e2e50] 2016-12-22 redone yii2-thememanager -> yii2-menus [@hiqsol]
    - [ccf1955] 2016-12-21 Fixed regression in SellerColumn [@SilverFire]
    - [b0cf44f] 2016-12-21 Fixed SellerCombo, SellerColumn to include onwers [@SilverFire]
    - [d26c2ca] 2016-12-21 redone Menus: widget instead of create+render [@hiqsol]
    - [af112fc] 2016-12-21 moved menus definitions to DI [@hiqsol]
    - [3dbacab] 2016-12-16 moved return to old panel to ahnames/hipanel package [@hiqsol]
    - [4a899ca] 2016-12-15 + Return to old panel link in client profile [@hiqsol]
    - [b42820d] 2016-12-15 Removed ContactCombo::client_id property as redundant [@SilverFire]
    - [0b6ec6e] 2016-12-12 Added documents view on contact details page [@SilverFire]
    - [4e7dfde] 2016-12-09 Integrated with documents [@SilverFire]
    - [4b72676] 2016-12-09 simplified messengers column in ClientGridView [@hiqsol]
    - [4067317] 2016-12-09 + messengers column to client [@hiqsol]
    - [0c64fd5] 2016-12-09 + client_id filtering in ContactCombo [@hiqsol]
    - [dc5c92c] 2016-12-08 used reg_data [@hiqsol]
    - [8ad9161] 2016-12-08 + mailing settings monthly_invoice [@hiqsol]
    - [11a0fb0] 2016-12-08 removed reg_data and tax_comment attributes from contact [@hiqsol]
    - [566d333] 2016-12-08 Removed unnecessary with [@tafid]
    - [030d00c] 2016-12-08 Added withContacts query [@tafid]
    - [7abd428] 2016-12-07 translation [@hiqsol]
    - [5571073] 2016-12-05 Added getLabels method, made getLevels more compact [@tafid]
    - [3ca331e] 2016-12-05 Added VerificationMark widget, CheckCircle removed [@tafid]
    - [eb604f1] 2016-12-02 Fixed askpincode [@tafid]
    - [cc56275] 2016-12-02 Follow CheckCircle namespace change [@SilverFire]
    - [c200b66] 2016-12-02 + getClient/_id to Client model [@hiqsol]
    - [b432170] 2016-12-02 removed contact change-contact action [@hiqsol]
    - [d2e7af3] 2016-12-01 Added name_v item [@tafid]
    - [79c2864] 2016-12-01 Added new items [@tafid]
    - [129b041] 2016-12-01 Fixed regular expression in LoginValidator to allow emails [@SilverFire]
    - [0f766c2] 2016-11-30 + contact reg_data - registration data [@hiqsol]
    - [7c5c3ad] 2016-11-30 + contact bank details [@hiqsol]
    - [da14766] 2016-11-30 + joinWith requisite at contact/view [@hiqsol]
    - [eac9d15] 2016-11-30 moved tax infomation inside of additional information [@hiqsol]
    - [e068021] 2016-11-30 + extraAttribute [@hiqsol]
    - [9073bb2] 2016-11-25 Contact::attachFiles action redone to use documents module [@SilverFire]
    - [053020c] 2016-11-25 Fixed get user name in breadcrumbs [@tafid]
    - [2405535] 2016-11-25 Added BackButton widget [@tafid]
    - [d945d29] 2016-11-25 Added method wich retrun first name and last name of user [@tafid]
    - [7b7661d] 2016-11-25 fixed where in sidebar menu config [@hiqsol]
    - [f269c91] 2016-11-25 redone getting client model with `joinWith` [@hiqsol]
    - [29030c9] 2016-11-24 Minor [@SilverFire]
    - [d64c09e] 2016-11-23 PHPDocs updated [@SilverFire]
    - [6519f61] 2016-11-21 Added ClientDetailMenu [@tafid]
    - [ffd9d10] 2016-11-21 Added ContactDetailMenu [@tafid]
    - [b5563be] 2016-11-21 Added icon attribute [@tafid]
    - [04cdae9] 2016-11-16 Made client create bulk [@tafid]
    - [b410f73] 2016-11-16 Disabled autocomplete [@tafid]
    - [e776834] 2016-11-15 Client domain settings - show only client's contacts [@SilverFire]
    - [5aecbb4] 2016-11-15 redone translation category to `hipanel:client` <- hipanel/client [@hiqsol]
    - [a4faef0] 2016-11-13 redone translation category to `hipanel:client` <- hipanel/client [@hiqsol]
    - [c76f85c] 2016-11-12 redone ticket translation category to hipanel:ticket [@hiqsol]
    - [e00590a] 2016-11-11 translations [@tafid]
    - [4e87edd] 2016-11-11 Changed client field to login for create and update [@tafid]
    - [ce8c06b] 2016-11-11 Added oldEmail field to Contacts and check if email is changed for ask pincode [@tafid]
    - [9cb2f82] 2016-11-10 still doing VAT [@hiqsol]
    - [6aabce4] 2016-11-10 Added new field Type on the create client [@tafid]
    - [9c158d8] 2016-11-10 Removed actions column form grid [@tafid]
    - [e104fbc] 2016-11-09 Changed clint actions [@tafid]
    - [4dc7e75] 2016-11-09 Fixed actions menu [@tafid]
    - [c5eb447] 2016-11-09 + Contact tax_comment [@hiqsol]
    - [f74ee44] 2016-11-08 used Box widget collapsing features [@hiqsol]
    - [217118c] 2016-11-08 + tax information management: VAT number and rate [@hiqsol]
    - [fa4961b] 2016-11-08 Changed actions column [@tafid]
    - [b21527e] 2016-11-08 + ContactActionsMenu [@hiqsol]
    - [c4c7573] 2016-11-08 fixed ClientActionsMenu, used hiqdev\menumanager\MenuButton [@hiqsol]
    - [83e1afe] 2016-11-07 + client delete [@hiqsol]
    - [e6af281] 2016-11-07 minor:retabed [@hiqsol]
    - [5e44acc] 2016-11-07 Added ActionsDropdown to client grid [@tafid]
    - [a6be4b5] 2016-11-07 Added ClientActionsMenu [@tafid]
    - [7cc41cd] 2016-11-07 fixed type and state filters [@hiqsol]
    - [45c72e2] 2016-11-03 Translations updated [@SilverFire]
    - [67c7e55] 2016-10-28 translations [@tafid]
    - [cc35c79] 2016-10-28 Added new translation for ticketSettingsModal [@tafid]
    - [00c0aa9] 2016-10-27 Fixed client `create` and `update`, make unique validation for `client` nad `email` attributes [@tafid]
    - [cf3e361] 2016-10-27 Added regExp `client` attribute validation [@tafid]
    - [3fd1ef2] 2016-10-27 translations [@tafid]
    - [7cfb27c] 2016-10-25 redone Confirmation -> Verification and fixed bugs [@hiqsol]
    - [5776f08] 2016-10-25 added Contact social_net [@hiqsol]
    - [7c4a997] 2016-10-13 Updated transations [@SilverFire]
    - [c8dee8e] 2016-09-22 removed unused hidev config [@hiqsol]
    - [65092ba] 2016-09-22 minor renaming [@hiqsol]
    - [af9eae4] 2016-09-22 redone menu to new style [@hiqsol]
    - [5243db9] 2016-08-24 redone subtitle to original Yii style [@hiqsol]
    - [e21f550] 2016-08-23 redone breadcrumbs to original Yii style [@hiqsol]
    - [4d9d873] 2016-08-01 translations [@hiqsol]
    - [f14b36f] 2016-07-28 fixed translations: app -> hipanel [@hiqsol]
    - [4bd719f] 2016-07-21 Removed Client and Seller filters from the AdvancedSearch view for non-support [@SilverFire]
    - [4781d36] 2016-07-20 Implemented contact attachments upload [@SilverFire]
    - [12bfde3] 2016-07-20 Updated translations [@SilverFire]
    - [9b3498c] 2016-07-19 Fixed pincode settings for client [@tafid]
    - [24943b1] 2016-07-18 translation [@tafid]
    - [c8a9180] 2016-07-18 Implementation of documents attachment started [@SilverFire]
    - [a9e2aff] 2016-07-18 used ClassValuesAction to implement: ip-restrictions, domain-settings, mailing-settings, ticket-settings [@hiqsol]
    - [530165b] 2016-07-15 Fixed Disable PIN-code [@tafid]
    - [c1eb887] 2016-07-15 Inited client-side requests for data verification [@SilverFire]
    - [d366847] 2016-07-15 Fixed Confirmation widget to work with multiple instances ont he same page [@SilverFire]
    - [f85854d] 2016-07-15 Updated translations [@SilverFire]
    - [b8208b5] 2016-07-15 Add translation. Add extra info for pincode disable [@tafid]
    - [72cd172] 2016-07-15 changed gravatar icon link to httpS [@hiqsol]
    - [2d4c4fd] 2016-06-30 hidden note_like filter from users [@hiqsol]
    - [5ecbec4] 2016-06-30 + client note_like filter [@hiqsol]
    - [75eba10] 2016-06-27 simplified attribute labels [@hiqsol]
    - [9427844] 2016-06-22 Added ArticleQuery, minor [@SilverFire]
    - [5d5590e] 2016-06-16 Changed Ref::getList to $this->getRefs in controllers, changed Ref::getList calling signature fo follow mmethod changes [@SilverFire]
    - [00f9aa4] 2016-06-16 Updated translationsg [@SilverFire]
    - [bbab883] 2016-06-16 added require `hiqdev/hipanel-core` [@hiqsol]
    - [77d8163] 2016-06-16 csfixed [@hiqsol]
    - [9712973] 2016-06-16 csfixed [@hiqsol]
    - [9c67f28] 2016-06-16 allowed build failure for PHP 5.5 [@hiqsol]
    - [991e3bc] 2016-06-15 tidying up kartik widgets [@hiqsol]
    - [82e7779] 2016-06-14 Updated translations [@SilverFire]
    - [49e6864] 2016-06-09 Fixed client temporary password setting [@SilverFire]
    - [5c0148a] 2016-06-09 Updated translations [@SilverFire]
    - [c0ba38b] 2016-06-03 improved client filter [@hiqsol]
    - [32d88f7] 2016-06-02 Add Note [@tafid]
    - [7d68937] 2016-06-02 fixed filtering by create time date range [@hiqsol]
    - [8f3d31f] 2016-05-31 Change index layout [@tafid]
    - [bd3bafd] 2016-05-31 adding temporary password [@hiqsol]
    - [bc312ed] 2016-05-31 used User::is() to check is current user [@hiqsol]
    - [4dbec0f] 2016-05-30 Fixed serach by email [@SilverFire]
    - [6e6549c] 2016-05-20 Added support for model to work without domain or client modules [@SilverFire]
    - [c7addb8] 2016-05-20 Added ClientQuery [@SilverFire]
    - [d74d2e2] 2016-05-18 redone to composer-config-plugin [@hiqsol]
    - [3d6d95a] 2016-05-13 Implemented contact confirmation [@SilverFire]
    - [8a0c95c] 2016-05-13 Updated translations [@SilverFire]
    - []
## 0.0.1 Under development
- Fixed (improved) client and contact view pages
    - [c14d897] 2016-04-22 phpcsfixed [@hiqsol]
    - [ffd157b] 2016-04-22 inited tests [@hiqsol]
    - [70f1aae] 2016-04-22 rehideved [@hiqsol]
    - [0f6f711] 2016-04-22 fixed build with asset-packagist [@hiqsol]
    - [6f08696] 2016-04-21 Updated ClientGridView - added `servers_spoiler` and `domains_spoiler` coulmns definition [@SilverFire]
    - [46c038c] 2016-04-21 Updated translations [@SilverFire]
    - [9d3cbc3] 2016-04-21 Added Client::getServers() [@SilverFire]
    - [1ca428d] 2016-03-28 Client Index action - redirect to client view, when user can not see other clients [@SilverFire]
    - [10750d9] 2016-03-28 ClientCombo, ContactCombo - changed URL to /search instad of /index [@SilverFire]
    - [e7ede0f] 2016-03-27 Minor [@SilverFire]
    - [694c41f] 2016-03-17 Translations update [@SilverFire]
    - [e9e5071] 2016-03-16 Translations update [@SilverFire]
    - [8fab9f5] 2016-03-16 Added missing translation [@SilverFire]
    - [2ffa701] 2016-02-18 purse block view moved to finance module [@hiqsol]
    - [2dcef2a] 2016-02-17 fixed showing unconfirmed email [@hiqsol]
    - [a110742] 2016-02-15 phpcsfixed [@hiqsol]
    - [dcdd8ee] 2016-02-15 rehideved [@hiqsol]
    - [0738089] 2016-02-15 + `email_new` change not confirmed [@hiqsol]
    - [4f66939] 2016-02-01 Client blockint/unblocking implemented [@SilverFire]
    - [a7f6e76] 2016-01-29 ClientCombo - changed URL to /index [@SilverFire]
    - [6a5633c] 2016-01-24 ClientCombo - URL changed to index instead of search [@SilverFire]
    - [5d6510c] 2016-01-22 Fixed ClientCombo search URL [@SilverFire]
    - [0ff8d04] 2015-12-25 Change-contact funcionality [@tafid]
    - [549052c] 2015-12-23 Change buttons color, add some classes to tabs [@tafid]
    - [5a919cf] 2015-12-17 Change avatar at Gravatar added [@tafid]
    - [fadb135] 2015-12-17 Add linke to Gravatar [@tafid]
    - [a7c6561] 2015-12-16 Client change password modal - password confirmation field has type = password now [@SilverFire]
    - [ddac6b2] 2015-12-10 Fixed clientChagePassword [@SilverFire]
    - [d5b3eeb] 2015-12-04 Classes notation changed from pathtoClassName to PHP 5.6 ClassName::class [@SilverFire]
    - [7ca2237] 2015-11-26 Change color Save button in Client form [@tafid]
    - [8c0f60e] 2015-11-26 Add Cancel button to Contact [@tafid]
- Added filter saving
    - [023c18b] 2016-01-22 IndexAction - added filterStorageMap [@SilverFire]
- Fixed minor issues and translation
    - [7da5e11] 2016-02-04 Added module-scope translations file [@SilverFire]
    - [6166c5a] 2016-01-29 added tranlations [@hiqsol]
    - [9a5a37e] 2015-12-09 Removed PHP short-tags [@SilverFire]
    - [9e45474] 2015-11-18 improved package description [@hiqsol]
    - [0b9d86c] 2015-11-12 Fixed wrong changes in 38a51276 [@SilverFire]
    - [01a6463] 2015-11-10 Added * for required fields in contact form [@BladeRoot]
    - [2cf1bc4] 2015-10-17 Contact model - changed fool typo [@SilverFire]
    - [c69b56b] 2015-10-06 moved DomainValidator to hipanel-core [@hiqsol]
    - [73ec523] 2015-09-21 got rid of Re::l [@hiqsol]
    - [84367d6] 2015-09-17 * improve language pack; - remove unnessary lines [@BladeRoot]
    - [876ddbd] 2015-09-16 * improve language pack [@BladeRoot]
    - [891b82c] 2015-09-16 simplified contact action url building [@hiqsol]
    - [1ec27c1] 2015-09-16 * change language [@BladeRoot]
    - [d691efe] 2015-09-14 redone sidebar menu with Yii::t, Menu::items() and proper visible [@hiqsol]
    - [616ce3d] 2015-09-16 minor fix [@hiqsol]
    - [0e008ed] 2015-09-04 + check for domain module available [@hiqsol]
    - [6d78e53] 2015-09-01 ClientCombo - changed search url [@SilverFire]
    - [ada64ec] 2015-08-31 + rule Contact::files [@hiqsol]
    - [1730333] 2015-08-27 ClientCombo - changed filter type to `type_in` Removed CountryCombo [@SilverFire]
    - [0765436] 2015-08-27 Fixed breadcrumbs subtitle [@SilverFire]
    - [d7e387c] 2015-08-27 Email [@tafid]
    - [7292109] 2015-08-27 Fixed deprecated method calling syntax [@SilverFire]
    - [3da8a11] 2015-08-26 Add filter by states [@tafid]
- Added ClientTicketSettings, PincodeSettings
    - [48edc3a] 2015-10-23 * Added ClientTicketSettings model [@SilverFire]
    - [a69fec5] 2015-10-21 Add Pincode settings functionality [@tafid]
    - [1e73530] 2015-10-20 Add ContactCombo, change html select to cobmo in domainSettingsModal [@tafid]
    - [85132ec] 2015-10-15 Added ticket option `new_messages_first` [@SilverFire]
- Fixed validations
    - [98f76cb] 2015-11-25 Internal IpValidator replaced with yii2 core one [@SilverFire]
    - [92426d9] 2015-10-21 Fix validation in domailSettings [@tafid]
    - [e0b2230] 2015-10-21 Fix IpRestriction validation; [@tafid]
    - [9ea9ea7] 2015-10-21 Add autoclear all text fields on related tab [@tafid]
    - [935cd6c] 2015-10-21 Add answer validation [@tafid]
- Added monthly invoices displaying and managing
    - [9473985] 2015-10-15 finished monthly invoices displaying and managing [@hiqsol]
    - [c43d3ca] 2015-10-08 simplified use of BlockModalButton [@hiqsol]
    - [bfb23f7] 2015-10-07 + adding purses info and invoices [@hiqsol]
    - [6d6d5f0] 2015-10-07 Client (un)blocking reimplemented with BlockModalButton [@SilverFire]
    - [bfa4efb] 2015-10-07 Added state and type constangs to the Client model [@SilverFire]
    - [4edfb36] 2015-10-07 + display organization in client details [@hiqsol]
- Added client settings modal forms
    - [824a9b7] 2015-10-07 fixed showing current user ip at `_ipRestrictionsModal` [@hiqsol]
    - [94a0fc3] 2015-10-07 used SettingsModal widget for client settings [@hiqsol]
    - [1e81c65] 2015-10-06 NOT FINISHED redoing Modal [@hiqsol]
    - [915e1ce] 2015-10-01 Fix loading modal forms [@tafid]
    - [df3e881] 2015-10-01 Add change password validation [@tafid]
    - [6a22a00] 2015-10-01 x merge: fix conflicts [@BladeRoot]
    - [f29402e] 2015-10-01 x fix actions; * improve code, refactoring [@BladeRoot]
    - [2f65a4c] 2015-09-29 Numerios changes [@tafid]
    - [13da8d0] 2015-09-29 Add ipRestrictions settings change [@tafid]
    - [9816a65] 2015-09-29 Add mailing settings saved functionality [@tafid]
    - [f6174b3] 2015-09-29 Fix. Remove useless code [@tafid]
    - [0f4d5d0] 2015-09-29 Merge conflict resolve [@tafid]
    - [112dba2] 2015-09-29 Add ticket settings functionality [@tafid]
    - [47775a1] 2015-09-29 Ticket Mail settings on client/view - try [@SilverFire]
    - [742bc15] 2015-09-29 Remove yii end [@tafid]
    - [473a0ba] 2015-09-29 Some changes in Modal forms [@tafid]
    - [8180a5f] 2015-09-28 Merge conflict resolve\ [@tafid]
    - [3820a03] 2015-09-28 Work with modal setting forms [@tafid]
    - [17525d5] 2015-09-25 `ClientGridView->credit` now uses RemoteXeditable [@SilverFire]
    - [38388e2] 2015-09-25 Fix css. Get a smaller the lagend tag [@tafid]
    - [38605a4] 2015-09-25 Change modal form size [@tafid]
    - [297e27c] 2015-09-25 Add ipRestriction form [@tafid]
    - [99d2275] 2015-09-25 Add ChangePassword form [@tafid]
    - [e7fe872] 2015-09-25 Add validation rules to settings modal forms [@tafid]
    - [c6c60e5] 2015-09-25 Add mailing form [@tafid]
    - [912158f] 2015-09-25 Add more suitable size to modal forms [@tafid]
    - [8e2de9c] 2015-09-25 Add initial modal forms to maing settings functionality [@tafid]
    - [f19763c] 2015-09-25 Add initial settings management to client page [@tafid]
    - [da35b3b] 2015-09-24 * move modal window block to widget [@BladeRoot]
    - [d9f1dc1] 2015-09-24 x merge [@BladeRoot]
    - [f6b0a38] 2015-09-24 x fixes: use not static funxtion; add scenario [@BladeRoot]
- Fixed SidebarMenu
    - [a2c26f2] 2015-09-24 * SidebarMenu 'where' to be straight after dashboard [@hiqsol]
- Added client blocking
    - [b2c4417] 2015-09-24 + blocking from BladeRoot [@hiqsol]
- Fixed client grid: improved look
    - [8b8006e] 2015-09-24 improved client Type widget: used none for client [@hiqsol]
    - [ce5f4b8] 2015-09-24 improved State widget [@hiqsol]
    - [623cf9b] 2015-09-24 fixed credit and currency columns [@hiqsol]
    - [d59538b] 2015-09-23 fixed link to client bills [@hiqsol]
    - [622ef79] 2015-09-23 + new functions and actions [@BladeRoot]
    - [4528100] 2015-09-23 improved client index page look [@hiqsol]
    - [fb6ec6f] 2015-09-22 + urlCallback for balance column for link to client bills [@hiqsol]
    - [4beab1c] 2015-09-21 * change view to get columns from grid; change action column in grid: default clients contact could not be deleted [@BladeRoot]
- Added client create functionality
    - [517243d] 2015-08-26 Add Create functionality [@tafid]
- Fixed client/seller sorting with sortAttribute
    - [723fa0f] 2015-08-26 used sortAttribute for client/seller sorting [@hiqsol]
- Fixed PHP warnings
    - [b4c204a] 2015-08-26 fixed PHP warnings [@hiqsol]
- Fixed name filtering at clients
    - [6e6b05f] 2015-08-26 Some fixes [@tafid]
    - [30e7b61] 2015-08-26 fixed name filtering [@hiqsol]
- Added confirming fields to contact model
    - [29a7fa6] 2015-08-26 + contact fields for confirm/ed [@hiqsol]
- Fixed access control, hidden unallowed actions
    - [0594724] 2015-08-26 fixed access control [@hiqsol]
    - [430f5bd] 2015-08-25 Some bugs is fixed [@tafid]
    - [4c625d3] 2015-08-25 Fix icons [@tafid]
- Fixed ClientColumn default value, filtering and visibility
    - [6a2d838] 2015-08-25 fixed disabling visibility [@hiqsol]
    - [2f8a949] 2015-08-21 Default value [@tafid]
    - [d89a49b] 2015-08-20 Changed SellerCombo filtering attribute [silverfire@advancedhosters.com]
- Fixed article index page
    - [599fe50] 2015-08-20 Reconstruct index page of Article [@tafid]
- Fixed: hidden client menu from users
    - [67a77ce] 2015-08-19 Fixed: hidden client menu from users [@hiqsol]
- Fixed filters, sorter and pager
    - [56cb0c4] 2015-08-17 Add idAttribute [@tafid]
    - [6614464] 2015-08-12 Check Contacts [@tafid]
    - [5699e4d] 2015-08-12 Add sorter and per page to Client and Contact [@tafid]
    - [0d836a7] 2015-08-11 Add sordeter [@tafid]
    - [fc943f1] 2015-08-05 Refactoring. Action Box [@tafid]
    - [eae1605] 2015-08-04 failed add visible [@hiqsol]
    - [121c1b9] 2015-08-04 * ClientColumn: fixed visible with `user->can('support')` [@hiqsol]
    - [c1bf269] 2015-08-04 improved details page for client and contact [@hiqsol]
    - [c375c48] 2015-08-03 Remove unuse uses [@tafid]
    - [a8d94a0] 2015-08-03 Fix conflict [@tafid]
    - [889d7b4] 2015-08-03 AdvancedSearch to index [@tafid]
    - [e9fe09b] 2015-08-03 Remove dump from delete action [@tafid]
- Changed advanced search and action box
    - [201980d] 2015-08-03 php-cs-fixed [@hiqsol]
    - [02b6a0a] 2015-08-03 improved index and search with new features of ActionBox [@hiqsol]
    - [1984329] 2015-08-03 Remote bulk button for index page [@tafid]
    - [f279ccd] 2015-08-03 Add Advanced Search to contact module [@tafid]
    - [9395aae] 2015-08-02 used Url::toSearch [@hiqsol]
    - [7dd84b0] 2015-08-02 * Plugin: + aliases [@hiqsol]
- Changed actions to SmartActions
    - [1b02f96] 2015-07-31 + index & view smart actions [@hiqsol]
    - [6bfe493] 2015-07-31 used Index & ViewAction [@hiqsol]
    - [b54696a] 2015-07-31 used ValidateFormAction [@hiqsol]
    - [9995065] 2015-07-31 checkbox moved left [@hiqsol]
    - [ef44b4d] 2015-07-31 + Advanced search [@hiqsol]
    - [cf8ba7c] 2015-07-30 Style and typo fixes [@SilverFire]
    - [d9a1f3e] 2015-07-30 Icons in action and boxed [@tafid]
    - [27bb115] 2015-07-29 + set credit xeditable [@hiqsol]
    - [02189a1] 2015-07-29 Add copy functionality to Contact part [@tafid]
    - [71132ea] 2015-07-29 Merge conflict [@tafid]
    - [85f25f9] 2015-07-29 Update action for contact [@tafid]
    - [1e14a53] 2015-07-29 Enter pincode modal in contact update [@tafid]
    - [dc3cce2] 2015-07-27 Pincode ask [@tafid]
- Changed details pages for clients and contacts
    - [358655b] 2015-07-28 proper contact details link made as tools button at client details [@hiqsol]
    - [680aa45] 2015-07-28 php-cs-fixed [@hiqsol]
    - [7da0576] 2015-07-28 improved client and contact details pages [@hiqsol]
    - [d6e660f] 2015-07-28 + change contact url [@hiqsol]
    - [7e9f556] 2015-07-28 - looking junk assets/combo2/Manager.php [@hiqsol]
    - [c36c243] 2015-07-27 + tickets/server/domains/contacts links at client details [@hiqsol]
    - [9130083] 2015-07-27 WE KEEP BACK `voice_phone`, `fax_phone` [@hiqsol]
    - [48fbad4] 2015-07-27 Fields `voice_phone` end `fax_phone` changed [@tafid]
    - [7b54782] 2015-07-27 Additional fields disable fix [@tafid]
    - [14bb9cc] 2015-07-24 Work [@tafid]
    - [51d8477] 2015-07-24 improved details pages for contacts and clients [@hiqsol]
    - [cfaaaa4] 2015-07-23 Confilct rsolve [@tafid]
    - [f488397] 2015-07-23 Add addtional field in rule [@tafid]
    - [f7eea1d] 2015-07-24 php-cs-fixed [@hiqsol]
    - [9345268] 2015-07-24 improving detail pages for clients and contacts [@hiqsol]
    - [b14a663] 2015-07-23 * contact details page [@hiqsol]
- moved to src and php-cs-fixed
    - [e0980e4] 2015-07-19 php-cs-fixed [@hiqsol]
    - [7e688f4] 2015-07-17 moved to src [@hiqsol]
    - [41561fa] 2015-07-17 BROKEN, in process [@hiqsol]
- hideved
    - [044bf73] 2015-06-01 hideved [@hiqsol]
    - [3c7f6bc] 2015-05-29 ResellerColumn ~> SellerColumn [@SilverFire]
    - [dd701b8] 2015-05-24 used yii2-asset-flag-icon-css [@hiqsol]
    - [1ed8e69] 2015-05-22 Client combo - updated parent namespace [@SilverFire]
    - [cdb4efe] 2015-05-20 article in new way [@BladeRoot]
    - [06a53e1] 2015-05-15 + Plugin, * Menu [@hiqsol]
    - [0a15efb] 2015-05-15 fixed combo <- combo2 [@hiqsol]
    - [401de5f] 2015-05-15 Merge commit 'dc9db3a' [@hiqsol]
    - [dc9db3a] 2015-05-14 + Menu.php and changed breacrumbing [@hiqsol]
    - [a47346a] 2015-05-14 Combo2 ~> Combo updates [@SilverFire]
    - [8561d37] 2015-05-12 Combo2 call updated [@SilverFire]
    - [e01cae6] 2015-05-02 Changes in Combo2 configs to suite new scheme [@SilverFire]
    - [6bced97] 2015-04-29 Code style and logic fixes [@SilverFire]
    - [b80e7d5] 2015-04-23 + column currency to rule [@BladeRoot]
    - [8ecb6a5] 2015-04-22 Action column example [@tafid]
    - [9566fa5] 2015-04-22 * fixes grids, models, views [@BladeRoot]
    - [189d203] 2015-04-22 * rewrite to according new style [@BladeRoot]
    - [d2d1633] 2015-04-22 * change dependence of model, rewrite [@BladeRoot]
    - [4bca566] 2015-04-22 * rewriting module: rule, labels [@BladeRoot]
    - [c85ef9b] 2015-04-22 - remove legacy [@BladeRoot]
    - [c7e3db8] 2015-04-21 - zero sense lines [@hiqsol]
    - [439eb4a] 2015-04-21 renamed to mergeAttributeLabels from margeA... [@hiqsol]
- inited
    - [d30b571] 2015-04-20 composer [@hiqsol]
    - [2d0df68] 2015-04-20 inited [@hiqsol]

## [Development started] - 2015-04-20

[@hiqsol]: https://github.com/hiqsol
[sol@hiqdev.com]: https://github.com/hiqsol
[@SilverFire]: https://github.com/SilverFire
[d.naumenko.a@gmail.com]: https://github.com/SilverFire
[@tafid]: https://github.com/tafid
[andreyklochok@gmail.com]: https://github.com/tafid
[@BladeRoot]: https://github.com/BladeRoot
[bladeroot@gmail.com]: https://github.com/BladeRoot
[c14d897]: https://github.com/hiqdev/hipanel-module-client/commit/c14d897
[ffd157b]: https://github.com/hiqdev/hipanel-module-client/commit/ffd157b
[70f1aae]: https://github.com/hiqdev/hipanel-module-client/commit/70f1aae
[0f6f711]: https://github.com/hiqdev/hipanel-module-client/commit/0f6f711
[6f08696]: https://github.com/hiqdev/hipanel-module-client/commit/6f08696
[46c038c]: https://github.com/hiqdev/hipanel-module-client/commit/46c038c
[9d3cbc3]: https://github.com/hiqdev/hipanel-module-client/commit/9d3cbc3
[1ca428d]: https://github.com/hiqdev/hipanel-module-client/commit/1ca428d
[10750d9]: https://github.com/hiqdev/hipanel-module-client/commit/10750d9
[e7ede0f]: https://github.com/hiqdev/hipanel-module-client/commit/e7ede0f
[694c41f]: https://github.com/hiqdev/hipanel-module-client/commit/694c41f
[e9e5071]: https://github.com/hiqdev/hipanel-module-client/commit/e9e5071
[8fab9f5]: https://github.com/hiqdev/hipanel-module-client/commit/8fab9f5
[2ffa701]: https://github.com/hiqdev/hipanel-module-client/commit/2ffa701
[2dcef2a]: https://github.com/hiqdev/hipanel-module-client/commit/2dcef2a
[a110742]: https://github.com/hiqdev/hipanel-module-client/commit/a110742
[dcdd8ee]: https://github.com/hiqdev/hipanel-module-client/commit/dcdd8ee
[0738089]: https://github.com/hiqdev/hipanel-module-client/commit/0738089
[4f66939]: https://github.com/hiqdev/hipanel-module-client/commit/4f66939
[a7f6e76]: https://github.com/hiqdev/hipanel-module-client/commit/a7f6e76
[6a5633c]: https://github.com/hiqdev/hipanel-module-client/commit/6a5633c
[5d6510c]: https://github.com/hiqdev/hipanel-module-client/commit/5d6510c
[0ff8d04]: https://github.com/hiqdev/hipanel-module-client/commit/0ff8d04
[549052c]: https://github.com/hiqdev/hipanel-module-client/commit/549052c
[5a919cf]: https://github.com/hiqdev/hipanel-module-client/commit/5a919cf
[fadb135]: https://github.com/hiqdev/hipanel-module-client/commit/fadb135
[a7c6561]: https://github.com/hiqdev/hipanel-module-client/commit/a7c6561
[ddac6b2]: https://github.com/hiqdev/hipanel-module-client/commit/ddac6b2
[d5b3eeb]: https://github.com/hiqdev/hipanel-module-client/commit/d5b3eeb
[7ca2237]: https://github.com/hiqdev/hipanel-module-client/commit/7ca2237
[8c0f60e]: https://github.com/hiqdev/hipanel-module-client/commit/8c0f60e
[023c18b]: https://github.com/hiqdev/hipanel-module-client/commit/023c18b
[7da5e11]: https://github.com/hiqdev/hipanel-module-client/commit/7da5e11
[6166c5a]: https://github.com/hiqdev/hipanel-module-client/commit/6166c5a
[9a5a37e]: https://github.com/hiqdev/hipanel-module-client/commit/9a5a37e
[9e45474]: https://github.com/hiqdev/hipanel-module-client/commit/9e45474
[0b9d86c]: https://github.com/hiqdev/hipanel-module-client/commit/0b9d86c
[01a6463]: https://github.com/hiqdev/hipanel-module-client/commit/01a6463
[2cf1bc4]: https://github.com/hiqdev/hipanel-module-client/commit/2cf1bc4
[c69b56b]: https://github.com/hiqdev/hipanel-module-client/commit/c69b56b
[73ec523]: https://github.com/hiqdev/hipanel-module-client/commit/73ec523
[84367d6]: https://github.com/hiqdev/hipanel-module-client/commit/84367d6
[876ddbd]: https://github.com/hiqdev/hipanel-module-client/commit/876ddbd
[891b82c]: https://github.com/hiqdev/hipanel-module-client/commit/891b82c
[1ec27c1]: https://github.com/hiqdev/hipanel-module-client/commit/1ec27c1
[d691efe]: https://github.com/hiqdev/hipanel-module-client/commit/d691efe
[616ce3d]: https://github.com/hiqdev/hipanel-module-client/commit/616ce3d
[0e008ed]: https://github.com/hiqdev/hipanel-module-client/commit/0e008ed
[6d78e53]: https://github.com/hiqdev/hipanel-module-client/commit/6d78e53
[ada64ec]: https://github.com/hiqdev/hipanel-module-client/commit/ada64ec
[1730333]: https://github.com/hiqdev/hipanel-module-client/commit/1730333
[0765436]: https://github.com/hiqdev/hipanel-module-client/commit/0765436
[d7e387c]: https://github.com/hiqdev/hipanel-module-client/commit/d7e387c
[7292109]: https://github.com/hiqdev/hipanel-module-client/commit/7292109
[3da8a11]: https://github.com/hiqdev/hipanel-module-client/commit/3da8a11
[48edc3a]: https://github.com/hiqdev/hipanel-module-client/commit/48edc3a
[a69fec5]: https://github.com/hiqdev/hipanel-module-client/commit/a69fec5
[1e73530]: https://github.com/hiqdev/hipanel-module-client/commit/1e73530
[85132ec]: https://github.com/hiqdev/hipanel-module-client/commit/85132ec
[98f76cb]: https://github.com/hiqdev/hipanel-module-client/commit/98f76cb
[92426d9]: https://github.com/hiqdev/hipanel-module-client/commit/92426d9
[e0b2230]: https://github.com/hiqdev/hipanel-module-client/commit/e0b2230
[9ea9ea7]: https://github.com/hiqdev/hipanel-module-client/commit/9ea9ea7
[935cd6c]: https://github.com/hiqdev/hipanel-module-client/commit/935cd6c
[9473985]: https://github.com/hiqdev/hipanel-module-client/commit/9473985
[c43d3ca]: https://github.com/hiqdev/hipanel-module-client/commit/c43d3ca
[bfb23f7]: https://github.com/hiqdev/hipanel-module-client/commit/bfb23f7
[6d6d5f0]: https://github.com/hiqdev/hipanel-module-client/commit/6d6d5f0
[bfa4efb]: https://github.com/hiqdev/hipanel-module-client/commit/bfa4efb
[4edfb36]: https://github.com/hiqdev/hipanel-module-client/commit/4edfb36
[824a9b7]: https://github.com/hiqdev/hipanel-module-client/commit/824a9b7
[94a0fc3]: https://github.com/hiqdev/hipanel-module-client/commit/94a0fc3
[1e81c65]: https://github.com/hiqdev/hipanel-module-client/commit/1e81c65
[915e1ce]: https://github.com/hiqdev/hipanel-module-client/commit/915e1ce
[df3e881]: https://github.com/hiqdev/hipanel-module-client/commit/df3e881
[6a22a00]: https://github.com/hiqdev/hipanel-module-client/commit/6a22a00
[f29402e]: https://github.com/hiqdev/hipanel-module-client/commit/f29402e
[2f65a4c]: https://github.com/hiqdev/hipanel-module-client/commit/2f65a4c
[13da8d0]: https://github.com/hiqdev/hipanel-module-client/commit/13da8d0
[9816a65]: https://github.com/hiqdev/hipanel-module-client/commit/9816a65
[f6174b3]: https://github.com/hiqdev/hipanel-module-client/commit/f6174b3
[0f4d5d0]: https://github.com/hiqdev/hipanel-module-client/commit/0f4d5d0
[112dba2]: https://github.com/hiqdev/hipanel-module-client/commit/112dba2
[47775a1]: https://github.com/hiqdev/hipanel-module-client/commit/47775a1
[742bc15]: https://github.com/hiqdev/hipanel-module-client/commit/742bc15
[473a0ba]: https://github.com/hiqdev/hipanel-module-client/commit/473a0ba
[8180a5f]: https://github.com/hiqdev/hipanel-module-client/commit/8180a5f
[3820a03]: https://github.com/hiqdev/hipanel-module-client/commit/3820a03
[17525d5]: https://github.com/hiqdev/hipanel-module-client/commit/17525d5
[38388e2]: https://github.com/hiqdev/hipanel-module-client/commit/38388e2
[38605a4]: https://github.com/hiqdev/hipanel-module-client/commit/38605a4
[297e27c]: https://github.com/hiqdev/hipanel-module-client/commit/297e27c
[99d2275]: https://github.com/hiqdev/hipanel-module-client/commit/99d2275
[e7fe872]: https://github.com/hiqdev/hipanel-module-client/commit/e7fe872
[c6c60e5]: https://github.com/hiqdev/hipanel-module-client/commit/c6c60e5
[912158f]: https://github.com/hiqdev/hipanel-module-client/commit/912158f
[8e2de9c]: https://github.com/hiqdev/hipanel-module-client/commit/8e2de9c
[f19763c]: https://github.com/hiqdev/hipanel-module-client/commit/f19763c
[da35b3b]: https://github.com/hiqdev/hipanel-module-client/commit/da35b3b
[d9f1dc1]: https://github.com/hiqdev/hipanel-module-client/commit/d9f1dc1
[f6b0a38]: https://github.com/hiqdev/hipanel-module-client/commit/f6b0a38
[a2c26f2]: https://github.com/hiqdev/hipanel-module-client/commit/a2c26f2
[b2c4417]: https://github.com/hiqdev/hipanel-module-client/commit/b2c4417
[8b8006e]: https://github.com/hiqdev/hipanel-module-client/commit/8b8006e
[ce5f4b8]: https://github.com/hiqdev/hipanel-module-client/commit/ce5f4b8
[623cf9b]: https://github.com/hiqdev/hipanel-module-client/commit/623cf9b
[d59538b]: https://github.com/hiqdev/hipanel-module-client/commit/d59538b
[622ef79]: https://github.com/hiqdev/hipanel-module-client/commit/622ef79
[4528100]: https://github.com/hiqdev/hipanel-module-client/commit/4528100
[fb6ec6f]: https://github.com/hiqdev/hipanel-module-client/commit/fb6ec6f
[4beab1c]: https://github.com/hiqdev/hipanel-module-client/commit/4beab1c
[517243d]: https://github.com/hiqdev/hipanel-module-client/commit/517243d
[723fa0f]: https://github.com/hiqdev/hipanel-module-client/commit/723fa0f
[b4c204a]: https://github.com/hiqdev/hipanel-module-client/commit/b4c204a
[6e6b05f]: https://github.com/hiqdev/hipanel-module-client/commit/6e6b05f
[30e7b61]: https://github.com/hiqdev/hipanel-module-client/commit/30e7b61
[29a7fa6]: https://github.com/hiqdev/hipanel-module-client/commit/29a7fa6
[0594724]: https://github.com/hiqdev/hipanel-module-client/commit/0594724
[430f5bd]: https://github.com/hiqdev/hipanel-module-client/commit/430f5bd
[4c625d3]: https://github.com/hiqdev/hipanel-module-client/commit/4c625d3
[6a2d838]: https://github.com/hiqdev/hipanel-module-client/commit/6a2d838
[2f8a949]: https://github.com/hiqdev/hipanel-module-client/commit/2f8a949
[d89a49b]: https://github.com/hiqdev/hipanel-module-client/commit/d89a49b
[599fe50]: https://github.com/hiqdev/hipanel-module-client/commit/599fe50
[67a77ce]: https://github.com/hiqdev/hipanel-module-client/commit/67a77ce
[56cb0c4]: https://github.com/hiqdev/hipanel-module-client/commit/56cb0c4
[6614464]: https://github.com/hiqdev/hipanel-module-client/commit/6614464
[5699e4d]: https://github.com/hiqdev/hipanel-module-client/commit/5699e4d
[0d836a7]: https://github.com/hiqdev/hipanel-module-client/commit/0d836a7
[fc943f1]: https://github.com/hiqdev/hipanel-module-client/commit/fc943f1
[eae1605]: https://github.com/hiqdev/hipanel-module-client/commit/eae1605
[121c1b9]: https://github.com/hiqdev/hipanel-module-client/commit/121c1b9
[c1bf269]: https://github.com/hiqdev/hipanel-module-client/commit/c1bf269
[c375c48]: https://github.com/hiqdev/hipanel-module-client/commit/c375c48
[a8d94a0]: https://github.com/hiqdev/hipanel-module-client/commit/a8d94a0
[889d7b4]: https://github.com/hiqdev/hipanel-module-client/commit/889d7b4
[e9fe09b]: https://github.com/hiqdev/hipanel-module-client/commit/e9fe09b
[201980d]: https://github.com/hiqdev/hipanel-module-client/commit/201980d
[02b6a0a]: https://github.com/hiqdev/hipanel-module-client/commit/02b6a0a
[1984329]: https://github.com/hiqdev/hipanel-module-client/commit/1984329
[f279ccd]: https://github.com/hiqdev/hipanel-module-client/commit/f279ccd
[9395aae]: https://github.com/hiqdev/hipanel-module-client/commit/9395aae
[7dd84b0]: https://github.com/hiqdev/hipanel-module-client/commit/7dd84b0
[1b02f96]: https://github.com/hiqdev/hipanel-module-client/commit/1b02f96
[6bfe493]: https://github.com/hiqdev/hipanel-module-client/commit/6bfe493
[b54696a]: https://github.com/hiqdev/hipanel-module-client/commit/b54696a
[9995065]: https://github.com/hiqdev/hipanel-module-client/commit/9995065
[ef44b4d]: https://github.com/hiqdev/hipanel-module-client/commit/ef44b4d
[cf8ba7c]: https://github.com/hiqdev/hipanel-module-client/commit/cf8ba7c
[d9a1f3e]: https://github.com/hiqdev/hipanel-module-client/commit/d9a1f3e
[27bb115]: https://github.com/hiqdev/hipanel-module-client/commit/27bb115
[02189a1]: https://github.com/hiqdev/hipanel-module-client/commit/02189a1
[71132ea]: https://github.com/hiqdev/hipanel-module-client/commit/71132ea
[85f25f9]: https://github.com/hiqdev/hipanel-module-client/commit/85f25f9
[1e14a53]: https://github.com/hiqdev/hipanel-module-client/commit/1e14a53
[dc3cce2]: https://github.com/hiqdev/hipanel-module-client/commit/dc3cce2
[358655b]: https://github.com/hiqdev/hipanel-module-client/commit/358655b
[680aa45]: https://github.com/hiqdev/hipanel-module-client/commit/680aa45
[7da0576]: https://github.com/hiqdev/hipanel-module-client/commit/7da0576
[d6e660f]: https://github.com/hiqdev/hipanel-module-client/commit/d6e660f
[7e9f556]: https://github.com/hiqdev/hipanel-module-client/commit/7e9f556
[c36c243]: https://github.com/hiqdev/hipanel-module-client/commit/c36c243
[9130083]: https://github.com/hiqdev/hipanel-module-client/commit/9130083
[48fbad4]: https://github.com/hiqdev/hipanel-module-client/commit/48fbad4
[7b54782]: https://github.com/hiqdev/hipanel-module-client/commit/7b54782
[14bb9cc]: https://github.com/hiqdev/hipanel-module-client/commit/14bb9cc
[51d8477]: https://github.com/hiqdev/hipanel-module-client/commit/51d8477
[cfaaaa4]: https://github.com/hiqdev/hipanel-module-client/commit/cfaaaa4
[f488397]: https://github.com/hiqdev/hipanel-module-client/commit/f488397
[f7eea1d]: https://github.com/hiqdev/hipanel-module-client/commit/f7eea1d
[9345268]: https://github.com/hiqdev/hipanel-module-client/commit/9345268
[b14a663]: https://github.com/hiqdev/hipanel-module-client/commit/b14a663
[e0980e4]: https://github.com/hiqdev/hipanel-module-client/commit/e0980e4
[7e688f4]: https://github.com/hiqdev/hipanel-module-client/commit/7e688f4
[41561fa]: https://github.com/hiqdev/hipanel-module-client/commit/41561fa
[044bf73]: https://github.com/hiqdev/hipanel-module-client/commit/044bf73
[3c7f6bc]: https://github.com/hiqdev/hipanel-module-client/commit/3c7f6bc
[dd701b8]: https://github.com/hiqdev/hipanel-module-client/commit/dd701b8
[1ed8e69]: https://github.com/hiqdev/hipanel-module-client/commit/1ed8e69
[cdb4efe]: https://github.com/hiqdev/hipanel-module-client/commit/cdb4efe
[06a53e1]: https://github.com/hiqdev/hipanel-module-client/commit/06a53e1
[0a15efb]: https://github.com/hiqdev/hipanel-module-client/commit/0a15efb
[401de5f]: https://github.com/hiqdev/hipanel-module-client/commit/401de5f
[dc9db3a]: https://github.com/hiqdev/hipanel-module-client/commit/dc9db3a
[a47346a]: https://github.com/hiqdev/hipanel-module-client/commit/a47346a
[8561d37]: https://github.com/hiqdev/hipanel-module-client/commit/8561d37
[e01cae6]: https://github.com/hiqdev/hipanel-module-client/commit/e01cae6
[6bced97]: https://github.com/hiqdev/hipanel-module-client/commit/6bced97
[b80e7d5]: https://github.com/hiqdev/hipanel-module-client/commit/b80e7d5
[8ecb6a5]: https://github.com/hiqdev/hipanel-module-client/commit/8ecb6a5
[9566fa5]: https://github.com/hiqdev/hipanel-module-client/commit/9566fa5
[189d203]: https://github.com/hiqdev/hipanel-module-client/commit/189d203
[d2d1633]: https://github.com/hiqdev/hipanel-module-client/commit/d2d1633
[4bca566]: https://github.com/hiqdev/hipanel-module-client/commit/4bca566
[c85ef9b]: https://github.com/hiqdev/hipanel-module-client/commit/c85ef9b
[c7e3db8]: https://github.com/hiqdev/hipanel-module-client/commit/c7e3db8
[439eb4a]: https://github.com/hiqdev/hipanel-module-client/commit/439eb4a
[d30b571]: https://github.com/hiqdev/hipanel-module-client/commit/d30b571
[2d0df68]: https://github.com/hiqdev/hipanel-module-client/commit/2d0df68
[ac8cbb7]: https://github.com/hiqdev/hipanel-module-client/commit/ac8cbb7
[ff3c56f]: https://github.com/hiqdev/hipanel-module-client/commit/ff3c56f
[2820494]: https://github.com/hiqdev/hipanel-module-client/commit/2820494
[ace63d1]: https://github.com/hiqdev/hipanel-module-client/commit/ace63d1
[435e68d]: https://github.com/hiqdev/hipanel-module-client/commit/435e68d
[8b04a41]: https://github.com/hiqdev/hipanel-module-client/commit/8b04a41
[48a9467]: https://github.com/hiqdev/hipanel-module-client/commit/48a9467
[1c681da]: https://github.com/hiqdev/hipanel-module-client/commit/1c681da
[5441604]: https://github.com/hiqdev/hipanel-module-client/commit/5441604
[add942d]: https://github.com/hiqdev/hipanel-module-client/commit/add942d
[b824971]: https://github.com/hiqdev/hipanel-module-client/commit/b824971
[42612dc]: https://github.com/hiqdev/hipanel-module-client/commit/42612dc
[53ff314]: https://github.com/hiqdev/hipanel-module-client/commit/53ff314
[c506864]: https://github.com/hiqdev/hipanel-module-client/commit/c506864
[1f5f84c]: https://github.com/hiqdev/hipanel-module-client/commit/1f5f84c
[88f778f]: https://github.com/hiqdev/hipanel-module-client/commit/88f778f
[959ad55]: https://github.com/hiqdev/hipanel-module-client/commit/959ad55
[2218115]: https://github.com/hiqdev/hipanel-module-client/commit/2218115
[4b1828b]: https://github.com/hiqdev/hipanel-module-client/commit/4b1828b
[da397d5]: https://github.com/hiqdev/hipanel-module-client/commit/da397d5
[3413638]: https://github.com/hiqdev/hipanel-module-client/commit/3413638
[2929f35]: https://github.com/hiqdev/hipanel-module-client/commit/2929f35
[994eefe]: https://github.com/hiqdev/hipanel-module-client/commit/994eefe
[14b8876]: https://github.com/hiqdev/hipanel-module-client/commit/14b8876
[cede170]: https://github.com/hiqdev/hipanel-module-client/commit/cede170
[03f1c23]: https://github.com/hiqdev/hipanel-module-client/commit/03f1c23
[1ce4335]: https://github.com/hiqdev/hipanel-module-client/commit/1ce4335
[f87da65]: https://github.com/hiqdev/hipanel-module-client/commit/f87da65
[ccd037a]: https://github.com/hiqdev/hipanel-module-client/commit/ccd037a
[9c7c274]: https://github.com/hiqdev/hipanel-module-client/commit/9c7c274
[e7681df]: https://github.com/hiqdev/hipanel-module-client/commit/e7681df
[6a1bb71]: https://github.com/hiqdev/hipanel-module-client/commit/6a1bb71
[27e80f8]: https://github.com/hiqdev/hipanel-module-client/commit/27e80f8
[f986751]: https://github.com/hiqdev/hipanel-module-client/commit/f986751
[119a93a]: https://github.com/hiqdev/hipanel-module-client/commit/119a93a
[2d26780]: https://github.com/hiqdev/hipanel-module-client/commit/2d26780
[db6288a]: https://github.com/hiqdev/hipanel-module-client/commit/db6288a
[4845175]: https://github.com/hiqdev/hipanel-module-client/commit/4845175
[3da216d]: https://github.com/hiqdev/hipanel-module-client/commit/3da216d
[7033e92]: https://github.com/hiqdev/hipanel-module-client/commit/7033e92
[ce28410]: https://github.com/hiqdev/hipanel-module-client/commit/ce28410
[151b5f2]: https://github.com/hiqdev/hipanel-module-client/commit/151b5f2
[944c23d]: https://github.com/hiqdev/hipanel-module-client/commit/944c23d
[44afcf9]: https://github.com/hiqdev/hipanel-module-client/commit/44afcf9
[25a0e71]: https://github.com/hiqdev/hipanel-module-client/commit/25a0e71
[123e089]: https://github.com/hiqdev/hipanel-module-client/commit/123e089
[8e16cb4]: https://github.com/hiqdev/hipanel-module-client/commit/8e16cb4
[af258c3]: https://github.com/hiqdev/hipanel-module-client/commit/af258c3
[27375e2]: https://github.com/hiqdev/hipanel-module-client/commit/27375e2
[84175b5]: https://github.com/hiqdev/hipanel-module-client/commit/84175b5
[62910f9]: https://github.com/hiqdev/hipanel-module-client/commit/62910f9
[abf2712]: https://github.com/hiqdev/hipanel-module-client/commit/abf2712
[d4c5c67]: https://github.com/hiqdev/hipanel-module-client/commit/d4c5c67
[1fb4722]: https://github.com/hiqdev/hipanel-module-client/commit/1fb4722
[866686a]: https://github.com/hiqdev/hipanel-module-client/commit/866686a
[d54a8dd]: https://github.com/hiqdev/hipanel-module-client/commit/d54a8dd
[895038d]: https://github.com/hiqdev/hipanel-module-client/commit/895038d
[5f156fb]: https://github.com/hiqdev/hipanel-module-client/commit/5f156fb
[d0effe9]: https://github.com/hiqdev/hipanel-module-client/commit/d0effe9
[437c09f]: https://github.com/hiqdev/hipanel-module-client/commit/437c09f
[4d8677e]: https://github.com/hiqdev/hipanel-module-client/commit/4d8677e
[63c2011]: https://github.com/hiqdev/hipanel-module-client/commit/63c2011
[ca2d2d0]: https://github.com/hiqdev/hipanel-module-client/commit/ca2d2d0
[465e746]: https://github.com/hiqdev/hipanel-module-client/commit/465e746
[d08074f]: https://github.com/hiqdev/hipanel-module-client/commit/d08074f
[01d5170]: https://github.com/hiqdev/hipanel-module-client/commit/01d5170
[813cef2]: https://github.com/hiqdev/hipanel-module-client/commit/813cef2
[6641aeb]: https://github.com/hiqdev/hipanel-module-client/commit/6641aeb
[5d2fa3a]: https://github.com/hiqdev/hipanel-module-client/commit/5d2fa3a
[f43687e]: https://github.com/hiqdev/hipanel-module-client/commit/f43687e
[588643d]: https://github.com/hiqdev/hipanel-module-client/commit/588643d
[b463d48]: https://github.com/hiqdev/hipanel-module-client/commit/b463d48
[d388957]: https://github.com/hiqdev/hipanel-module-client/commit/d388957
[b92f2ed]: https://github.com/hiqdev/hipanel-module-client/commit/b92f2ed
[262c399]: https://github.com/hiqdev/hipanel-module-client/commit/262c399
[4f9408f]: https://github.com/hiqdev/hipanel-module-client/commit/4f9408f
[f18faf8]: https://github.com/hiqdev/hipanel-module-client/commit/f18faf8
[5136cf7]: https://github.com/hiqdev/hipanel-module-client/commit/5136cf7
[f29b172]: https://github.com/hiqdev/hipanel-module-client/commit/f29b172
[1998768]: https://github.com/hiqdev/hipanel-module-client/commit/1998768
[776673f]: https://github.com/hiqdev/hipanel-module-client/commit/776673f
[579de2b]: https://github.com/hiqdev/hipanel-module-client/commit/579de2b
[97eb4a2]: https://github.com/hiqdev/hipanel-module-client/commit/97eb4a2
[a2b18dc]: https://github.com/hiqdev/hipanel-module-client/commit/a2b18dc
[ed36c51]: https://github.com/hiqdev/hipanel-module-client/commit/ed36c51
[931e7b8]: https://github.com/hiqdev/hipanel-module-client/commit/931e7b8
[61f5469]: https://github.com/hiqdev/hipanel-module-client/commit/61f5469
[1cc1599]: https://github.com/hiqdev/hipanel-module-client/commit/1cc1599
[0939aaa]: https://github.com/hiqdev/hipanel-module-client/commit/0939aaa
[089970b]: https://github.com/hiqdev/hipanel-module-client/commit/089970b
[2eb1cef]: https://github.com/hiqdev/hipanel-module-client/commit/2eb1cef
[879baac]: https://github.com/hiqdev/hipanel-module-client/commit/879baac
[30cb9a2]: https://github.com/hiqdev/hipanel-module-client/commit/30cb9a2
[8849a96]: https://github.com/hiqdev/hipanel-module-client/commit/8849a96
[542dc6f]: https://github.com/hiqdev/hipanel-module-client/commit/542dc6f
[2ae0d57]: https://github.com/hiqdev/hipanel-module-client/commit/2ae0d57
[6dff676]: https://github.com/hiqdev/hipanel-module-client/commit/6dff676
[a8e88f6]: https://github.com/hiqdev/hipanel-module-client/commit/a8e88f6
[80e2e50]: https://github.com/hiqdev/hipanel-module-client/commit/80e2e50
[ccf1955]: https://github.com/hiqdev/hipanel-module-client/commit/ccf1955
[b0cf44f]: https://github.com/hiqdev/hipanel-module-client/commit/b0cf44f
[d26c2ca]: https://github.com/hiqdev/hipanel-module-client/commit/d26c2ca
[af112fc]: https://github.com/hiqdev/hipanel-module-client/commit/af112fc
[3dbacab]: https://github.com/hiqdev/hipanel-module-client/commit/3dbacab
[4a899ca]: https://github.com/hiqdev/hipanel-module-client/commit/4a899ca
[b42820d]: https://github.com/hiqdev/hipanel-module-client/commit/b42820d
[0b6ec6e]: https://github.com/hiqdev/hipanel-module-client/commit/0b6ec6e
[4e7dfde]: https://github.com/hiqdev/hipanel-module-client/commit/4e7dfde
[4b72676]: https://github.com/hiqdev/hipanel-module-client/commit/4b72676
[4067317]: https://github.com/hiqdev/hipanel-module-client/commit/4067317
[0c64fd5]: https://github.com/hiqdev/hipanel-module-client/commit/0c64fd5
[dc5c92c]: https://github.com/hiqdev/hipanel-module-client/commit/dc5c92c
[8ad9161]: https://github.com/hiqdev/hipanel-module-client/commit/8ad9161
[11a0fb0]: https://github.com/hiqdev/hipanel-module-client/commit/11a0fb0
[566d333]: https://github.com/hiqdev/hipanel-module-client/commit/566d333
[030d00c]: https://github.com/hiqdev/hipanel-module-client/commit/030d00c
[7abd428]: https://github.com/hiqdev/hipanel-module-client/commit/7abd428
[5571073]: https://github.com/hiqdev/hipanel-module-client/commit/5571073
[3ca331e]: https://github.com/hiqdev/hipanel-module-client/commit/3ca331e
[eb604f1]: https://github.com/hiqdev/hipanel-module-client/commit/eb604f1
[cc56275]: https://github.com/hiqdev/hipanel-module-client/commit/cc56275
[c200b66]: https://github.com/hiqdev/hipanel-module-client/commit/c200b66
[b432170]: https://github.com/hiqdev/hipanel-module-client/commit/b432170
[d2e7af3]: https://github.com/hiqdev/hipanel-module-client/commit/d2e7af3
[79c2864]: https://github.com/hiqdev/hipanel-module-client/commit/79c2864
[129b041]: https://github.com/hiqdev/hipanel-module-client/commit/129b041
[0f766c2]: https://github.com/hiqdev/hipanel-module-client/commit/0f766c2
[7c5c3ad]: https://github.com/hiqdev/hipanel-module-client/commit/7c5c3ad
[da14766]: https://github.com/hiqdev/hipanel-module-client/commit/da14766
[eac9d15]: https://github.com/hiqdev/hipanel-module-client/commit/eac9d15
[e068021]: https://github.com/hiqdev/hipanel-module-client/commit/e068021
[9073bb2]: https://github.com/hiqdev/hipanel-module-client/commit/9073bb2
[053020c]: https://github.com/hiqdev/hipanel-module-client/commit/053020c
[2405535]: https://github.com/hiqdev/hipanel-module-client/commit/2405535
[d945d29]: https://github.com/hiqdev/hipanel-module-client/commit/d945d29
[7b7661d]: https://github.com/hiqdev/hipanel-module-client/commit/7b7661d
[f269c91]: https://github.com/hiqdev/hipanel-module-client/commit/f269c91
[29030c9]: https://github.com/hiqdev/hipanel-module-client/commit/29030c9
[d64c09e]: https://github.com/hiqdev/hipanel-module-client/commit/d64c09e
[6519f61]: https://github.com/hiqdev/hipanel-module-client/commit/6519f61
[ffd9d10]: https://github.com/hiqdev/hipanel-module-client/commit/ffd9d10
[b5563be]: https://github.com/hiqdev/hipanel-module-client/commit/b5563be
[04cdae9]: https://github.com/hiqdev/hipanel-module-client/commit/04cdae9
[b410f73]: https://github.com/hiqdev/hipanel-module-client/commit/b410f73
[e776834]: https://github.com/hiqdev/hipanel-module-client/commit/e776834
[5aecbb4]: https://github.com/hiqdev/hipanel-module-client/commit/5aecbb4
[a4faef0]: https://github.com/hiqdev/hipanel-module-client/commit/a4faef0
[c76f85c]: https://github.com/hiqdev/hipanel-module-client/commit/c76f85c
[e00590a]: https://github.com/hiqdev/hipanel-module-client/commit/e00590a
[4e87edd]: https://github.com/hiqdev/hipanel-module-client/commit/4e87edd
[ce8c06b]: https://github.com/hiqdev/hipanel-module-client/commit/ce8c06b
[9cb2f82]: https://github.com/hiqdev/hipanel-module-client/commit/9cb2f82
[6aabce4]: https://github.com/hiqdev/hipanel-module-client/commit/6aabce4
[9c158d8]: https://github.com/hiqdev/hipanel-module-client/commit/9c158d8
[e104fbc]: https://github.com/hiqdev/hipanel-module-client/commit/e104fbc
[4dc7e75]: https://github.com/hiqdev/hipanel-module-client/commit/4dc7e75
[c5eb447]: https://github.com/hiqdev/hipanel-module-client/commit/c5eb447
[f74ee44]: https://github.com/hiqdev/hipanel-module-client/commit/f74ee44
[217118c]: https://github.com/hiqdev/hipanel-module-client/commit/217118c
[fa4961b]: https://github.com/hiqdev/hipanel-module-client/commit/fa4961b
[b21527e]: https://github.com/hiqdev/hipanel-module-client/commit/b21527e
[c4c7573]: https://github.com/hiqdev/hipanel-module-client/commit/c4c7573
[83e1afe]: https://github.com/hiqdev/hipanel-module-client/commit/83e1afe
[e6af281]: https://github.com/hiqdev/hipanel-module-client/commit/e6af281
[5e44acc]: https://github.com/hiqdev/hipanel-module-client/commit/5e44acc
[a6be4b5]: https://github.com/hiqdev/hipanel-module-client/commit/a6be4b5
[7cc41cd]: https://github.com/hiqdev/hipanel-module-client/commit/7cc41cd
[45c72e2]: https://github.com/hiqdev/hipanel-module-client/commit/45c72e2
[67c7e55]: https://github.com/hiqdev/hipanel-module-client/commit/67c7e55
[cc35c79]: https://github.com/hiqdev/hipanel-module-client/commit/cc35c79
[00c0aa9]: https://github.com/hiqdev/hipanel-module-client/commit/00c0aa9
[cf3e361]: https://github.com/hiqdev/hipanel-module-client/commit/cf3e361
[3fd1ef2]: https://github.com/hiqdev/hipanel-module-client/commit/3fd1ef2
[7cfb27c]: https://github.com/hiqdev/hipanel-module-client/commit/7cfb27c
[5776f08]: https://github.com/hiqdev/hipanel-module-client/commit/5776f08
[7c4a997]: https://github.com/hiqdev/hipanel-module-client/commit/7c4a997
[c8dee8e]: https://github.com/hiqdev/hipanel-module-client/commit/c8dee8e
[65092ba]: https://github.com/hiqdev/hipanel-module-client/commit/65092ba
[af9eae4]: https://github.com/hiqdev/hipanel-module-client/commit/af9eae4
[5243db9]: https://github.com/hiqdev/hipanel-module-client/commit/5243db9
[e21f550]: https://github.com/hiqdev/hipanel-module-client/commit/e21f550
[4d9d873]: https://github.com/hiqdev/hipanel-module-client/commit/4d9d873
[f14b36f]: https://github.com/hiqdev/hipanel-module-client/commit/f14b36f
[4bd719f]: https://github.com/hiqdev/hipanel-module-client/commit/4bd719f
[4781d36]: https://github.com/hiqdev/hipanel-module-client/commit/4781d36
[12bfde3]: https://github.com/hiqdev/hipanel-module-client/commit/12bfde3
[9b3498c]: https://github.com/hiqdev/hipanel-module-client/commit/9b3498c
[24943b1]: https://github.com/hiqdev/hipanel-module-client/commit/24943b1
[c8a9180]: https://github.com/hiqdev/hipanel-module-client/commit/c8a9180
[a9e2aff]: https://github.com/hiqdev/hipanel-module-client/commit/a9e2aff
[530165b]: https://github.com/hiqdev/hipanel-module-client/commit/530165b
[c1eb887]: https://github.com/hiqdev/hipanel-module-client/commit/c1eb887
[d366847]: https://github.com/hiqdev/hipanel-module-client/commit/d366847
[f85854d]: https://github.com/hiqdev/hipanel-module-client/commit/f85854d
[b8208b5]: https://github.com/hiqdev/hipanel-module-client/commit/b8208b5
[72cd172]: https://github.com/hiqdev/hipanel-module-client/commit/72cd172
[2d4c4fd]: https://github.com/hiqdev/hipanel-module-client/commit/2d4c4fd
[5ecbec4]: https://github.com/hiqdev/hipanel-module-client/commit/5ecbec4
[75eba10]: https://github.com/hiqdev/hipanel-module-client/commit/75eba10
[9427844]: https://github.com/hiqdev/hipanel-module-client/commit/9427844
[5d5590e]: https://github.com/hiqdev/hipanel-module-client/commit/5d5590e
[00f9aa4]: https://github.com/hiqdev/hipanel-module-client/commit/00f9aa4
[bbab883]: https://github.com/hiqdev/hipanel-module-client/commit/bbab883
[77d8163]: https://github.com/hiqdev/hipanel-module-client/commit/77d8163
[9712973]: https://github.com/hiqdev/hipanel-module-client/commit/9712973
[9c67f28]: https://github.com/hiqdev/hipanel-module-client/commit/9c67f28
[991e3bc]: https://github.com/hiqdev/hipanel-module-client/commit/991e3bc
[82e7779]: https://github.com/hiqdev/hipanel-module-client/commit/82e7779
[49e6864]: https://github.com/hiqdev/hipanel-module-client/commit/49e6864
[5c0148a]: https://github.com/hiqdev/hipanel-module-client/commit/5c0148a
[c0ba38b]: https://github.com/hiqdev/hipanel-module-client/commit/c0ba38b
[32d88f7]: https://github.com/hiqdev/hipanel-module-client/commit/32d88f7
[7d68937]: https://github.com/hiqdev/hipanel-module-client/commit/7d68937
[8f3d31f]: https://github.com/hiqdev/hipanel-module-client/commit/8f3d31f
[bd3bafd]: https://github.com/hiqdev/hipanel-module-client/commit/bd3bafd
[bc312ed]: https://github.com/hiqdev/hipanel-module-client/commit/bc312ed
[4dbec0f]: https://github.com/hiqdev/hipanel-module-client/commit/4dbec0f
[6e6549c]: https://github.com/hiqdev/hipanel-module-client/commit/6e6549c
[c7addb8]: https://github.com/hiqdev/hipanel-module-client/commit/c7addb8
[d74d2e2]: https://github.com/hiqdev/hipanel-module-client/commit/d74d2e2
[3d6d95a]: https://github.com/hiqdev/hipanel-module-client/commit/3d6d95a
[8a0c95c]: https://github.com/hiqdev/hipanel-module-client/commit/8a0c95c
[Under development]: https://github.com/hiqdev/hipanel-module-client/releases
