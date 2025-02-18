import {test, getUserId} from "@hipanel-core/fixtures";
import {expect} from "@playwright/test";
import ClientView from "@hipanel-module-client/page/ClientView";

test.describe("Pincode Visibility Tests", () => {
    test("Verify content when PIN is enabled @hipanel-module-client @admin", async ({ adminPage}) => {
        const clientViewPage = new ClientView(adminPage);
        const userId = getUserId('admin');
        await clientViewPage.gotoClientView(userId, 'hipanel_test_admin');

        await clientViewPage.openPincodeSettingsWindow();

        // Check expected messages
        const messages = [
            "You have already set a PIN code.",
            "In order to disable it, enter your current PIN or the secret question."
        ];
        for (const message of messages) {
            await expect(adminPage.locator(`text=${message}`)).toBeVisible();
        }

        // Check UI elements
        const elements = [
            ["text=Disable pincode", '//a[@data-toggle="tab"]'],
            ["text=Forgot pincode?", '//a[@data-toggle="tab"]'],
            ["text=Enter pincode", ".control-label"],
            ["text=Save", "button"],
            ["text=Cancel", "button"]
        ];
        for (const [text, selector] of elements) {
            await expect(adminPage.locator(selector)).toContainText(text);
        }

        // Test question selection
        await adminPage.locator("text=Forgot pincode?").click();
        await expect(adminPage.locator("text=What is your grandmother’s maiden name?")).toBeVisible();
        await adminPage.locator("text=Cancel").click();
    });

    test("Verify content when PIN is disabled @hipanel-module-client @admin", async ({ adminPage }) => {
        const clientViewPage = new ClientView(adminPage);
        const userId = getUserId('admin');
        await clientViewPage.gotoClientView(userId, 'hipanel_test_admin');

        await clientViewPage.openPincodeSettingsWindow();

        // Check expected messages
        const messages = [
            "To further protect your account, you can install a pin code.\n" +
            "The following operations, Push domain, Obtaining an authorization code for a domain transfer,\n" +
            "Change the email address of the account's primary contact,\n" +
            "will be executed only when the correct PIN code is entered.\n" +
            "In order to be able to disable the pin code in the future,\n" +
            "it is required to ask an answer to a security question.",
            "In case you forget the PIN code or answer to a secret question,\n" +
            "you can disconnect the PIN code only through the support service!\n" +
            "(You will need to verify your account by providing a copy of the documents)"
        ];
        for (const message of messages) {
            await expect(adminPage.locator(`text=${message}`)).toBeVisible();
        }

        // Check UI elements
        const elements = [
            ["text=Enter pincode", ".control-label"],
            ["text=Choose question", ".control-label"],
            ["text=Answer", ".control-label"],
            ["text=Save", "button"],
            ["text=Cancel", "button"]
        ];
        for (const [text, selector] of elements) {
            await expect(adminPage.locator(selector)).toContainText(text);
        }

        // Check available security questions
        await adminPage.locator("text=Choose question").click();
        const questions = [
            "What was your nickname when you were a child?",
            "What was the name of your best childhood friend?",
            "What is the month and the year of birth of your oldest relative?",
            "What is your grandmother’s maiden name?",
            "What is the patronymic of your oldest relative?",
            "Own question"
        ];
        for (const question of questions) {
            await expect(adminPage.locator(`text=${question}`)).toBeVisible();
        }

        await adminPage.locator("text=Cancel").click();
    });
});