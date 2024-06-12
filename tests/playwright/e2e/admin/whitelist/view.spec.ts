import { test } from "@hipanel-core/fixtures";
import BlacklistHelper from "@hipanel-module-client/helper/Blacklist";
import WhitelistCategory from "@hipanel-module-client/helper/category/WhitelistCategory";
import Blacklist from "@hipanel-module-client/model/Blacklist";

const whiteItemForTestView = new Blacklist();
whiteItemForTestView.name = 'whitelist_test_view_item';
whiteItemForTestView.type = 'Domain';
whiteItemForTestView.message = 'Test Whitelist view page';
whiteItemForTestView.showMessage = 'Yes';

test("Correct view Whitelist @hipanel-module-client @admin", async ({ adminPage }) => {
    const blacklistHelper = new BlacklistHelper(adminPage, new WhitelistCategory());

    await blacklistHelper.gotoIndexBlacklist();

    if (await blacklistHelper.getRowsOnIndexPage() === 0) {
        whiteItemForTestView.id = await blacklistHelper.createBlacklist(new WhitelistCategory(), whiteItemForTestView);
        await blacklistHelper.gotoIndexBlacklist();
    }

    let blacklist = await blacklistHelper.fillBlacklistFromIndexPage(1);
    await blacklistHelper.gotoBlacklistPage(1);
    await blacklistHelper.checkDetailViewData(blacklist);

    await blacklistHelper.checkDetailViewData(blacklist);

    if (whiteItemForTestView.id) {
        await blacklistHelper.deleteBlacklist(whiteItemForTestView.id);
    }
});

