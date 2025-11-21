import { getUserId, test } from "@hipanel-core/fixtures";
import { expect } from "@playwright/test";
import ClientView from "@hipanel-module-client/page/ClientView";

test.describe("Pincode Visibility Tests", () => {
  test("Verify content when PIN is enabled @hipanel-module-client @admin", async ({ adminPage }) => {
    const clientViewPage = new ClientView(adminPage);
    const userId = getUserId("admin");
    await clientViewPage.gotoClientView(userId, "hipanel_test_admin");
    const pincodeForm = clientViewPage.getPincodeForm();
    const pincode = "1234";

    await pincodeForm.enablePin(pincode, "What is your grandmother’s maiden name?", "test answer");
    await pincodeForm.loadPincodeForm();

    // Check expected messages
    const messages = [
      "You have already set a PIN code.",
      "In order to disable it, enter your current PIN or the secret question.",
    ];
    for (const message of messages) {
      await expect(adminPage.locator(`text=${message}`)).toBeVisible();
    }

    // Check UI elements
    const elements = [
      ["a[data-toggle=tab]:has-text(\"Disable pincode\")"],
      ["a[data-toggle=tab]:has-text(\"Forgot pincode?\")"],
      ["label:has-text(\"Enter pincode\")"],
      ["button:has-text(\"Save\")"],
      ["button:has-text(\"Cancel\")"],
    ];
    for (const [selector] of elements) {
      await expect(adminPage.locator(selector)).toBeVisible();
    }

    // Check "Forgot pincode" UI elements
    await adminPage.locator("a[data-toggle=tab]:has-text(\"Forgot pincode?\")").click();
    await expect(adminPage.locator("text=What is your grandmother’s maiden name?")).toBeVisible();

    await pincodeForm.closePincodeForm();

    await pincodeForm.disablePinUsingPincode(pincode);
  });

  test("Verify content when PIN is disabled @hipanel-module-client @admin", async ({ adminPage }) => {
    const clientViewPage = new ClientView(adminPage);
    const userId = getUserId("admin");
    await clientViewPage.gotoClientView(userId, "hipanel_test_admin");
    const pincodeForm = clientViewPage.getPincodeForm();

    await pincodeForm.loadPincodeForm();

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
      "(You will need to verify your account by providing a copy of the documents)",
    ];
    for (const message of messages) {
      await expect(adminPage.locator(`text=${message}`)).toBeVisible();
    }

    // Check UI elements
    const elements = [
      ["label:has-text(\"Enter pincode\")"],
      ["label:has-text(\"Choose question\")"],
      ["label:has-text(\"Answer\")"],
      ["button:has-text(\"Save\")"],
      ["button:has-text(\"Cancel\")"],
    ];
    for (const [selector] of elements) {
      await expect(adminPage.locator(selector)).toBeVisible();
    }

    // Check available security questions
    const questionDropdown = pincodeForm.theSecurityQuestionDropdown();
    const questions = [
      "What was your nickname when you were a child?",
      "What was the name of your best childhood friend?",
      "What is the month and the year of birth of your oldest relative?",
      "What is your grandmother’s maiden name?",
      "What is the patronymic of your oldest relative?",
      "Own question",
    ];

    for (const question of questions) {
      await expect(questionDropdown.getByRole("option", { name: question })).toBeEnabled();
    }

    await pincodeForm.closePincodeForm();
  });
});
