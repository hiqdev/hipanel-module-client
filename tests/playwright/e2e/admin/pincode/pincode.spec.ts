import { expect, getUserId, test } from "@hipanel-core/fixtures";
import ClientView from "@hipanel-module-client/page/ClientView";
import PincodeForm from "@hipanel-module-client/helper/PincodeForm";

test.describe("Pincode Settings", () => {
  let pincodeForm: PincodeForm;

  test.beforeEach(async ({ adminPage }) => {
    const clientViewPage = new ClientView(adminPage);
    const userId = getUserId("admin");
    await clientViewPage.gotoClientView(userId, "hipanel_test_admin");
    pincodeForm = clientViewPage.getPincodeForm();
  });

  test("Pnotify Errors @hipanel-module-client @admin", async () => {
    const testCases = [
      { pin: "", answer: "test answer", message: "no data given", ownQuestion: null },
      { pin: "1234", answer: "", message: "wrong input: answer", ownQuestion: null },
      { pin: "1234", answer: "test answer", message: "wrong input: question", ownQuestion: "" },
    ];

    for (const { pin, answer, message, ownQuestion } of testCases) {
      await pincodeForm.loadPincodeForm();
      await pincodeForm.fillPincode(pin);
      await pincodeForm.fillAnswer(answer);

      if (ownQuestion !== null) {
        await pincodeForm.fillOwnQuestion(ownQuestion);
      }
      await pincodeForm.savePincodeFormWithMessage(message);
    }
  });

  test("PIN input validation @hipanel-module-client @admin", async () => {
    const testCases = [
      { pin: "123", message: "Enter pincode should contain at least 4 characters." },
      { pin: "12345", message: "Enter pincode should contain at most 4 characters." },
    ];

    for (const { pin, message } of testCases) {
      await pincodeForm.loadPincodeForm();
      await pincodeForm.fillPincode(pin);
      await pincodeForm.clickSaveButton();
      const errorMessage = pincodeForm.pincode()
        .locator("xpath=ancestor::div[contains(@class, \"has-error\")]//p[contains(@class, \"help-block-error\")]");
      await expect(errorMessage).toBeVisible();
      await expect(errorMessage).toHaveText(message);
      await pincodeForm.closePincodeForm();
    }
  });

  test("Disable PIN by pincode @hipanel-module-client @admin", async ({ adminPage }) => {
    await pincodeForm.loadPincodeForm();
    await pincodeForm.fillPincode("1234");
    await pincodeForm.fillAnswer("test answer");
    await pincodeForm.savePincodeFormSuccessfully();
    await pincodeForm.disablePinUsingPincode("1234");
  });

  test("Disable PIN by question @hipanel-module-client @admin", async ({ adminPage }) => {
    await pincodeForm.loadPincodeForm();
    await pincodeForm.fillPincode("1234");
    await pincodeForm.fillAnswer("test answer");
    await pincodeForm.chooseQuestion("What is your grandmother’s maiden name?", "test answer");
    await pincodeForm.savePincodeFormSuccessfully();
    await pincodeForm.disablePinUsingAnswer("What is your grandmother’s maiden name?", "test answer");
  });

  test("Disable PIN by own question @hipanel-module-client @admin", async ({ adminPage }) => {
    await pincodeForm.loadPincodeForm();
    await pincodeForm.fillPincode("1234");
    await pincodeForm.fillAnswer("test answer");
    await pincodeForm.fillOwnQuestion("test question");
    await pincodeForm.savePincodeFormSuccessfully();
    await pincodeForm.disablePinUsingAnswer("test question", "test answer");
  });
});
