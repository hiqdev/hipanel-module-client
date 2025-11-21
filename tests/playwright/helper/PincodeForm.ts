import { Locator, Page } from "@playwright/test";
import ClientView from "@hipanel-module-client/page/ClientView";
import { Alert } from "@hipanel-core/shared/ui/components";

export default class PincodeForm {
  private page: Page;
  private view: ClientView;
  private alert: Alert;

  constructor(page: Page, view: ClientView) {
    this.page = page;
    this.view = view;
    this.alert = Alert.on(page);
  }

  async loadPincodeForm() {
    await this.view.detailMenuItem("Pincode settings").click();
    await this.getForm().isVisible();
  }

  getForm(): Locator {
    return this.page.locator("#pincode-settings-form");
  }

  async closePincodeForm() {
    await this.page.locator("button:has-text(\"Cancel\")").click();
  }

  async enablePin(pincode: string, question: string, answer: string) {
    this.loadPincodeForm();

    await this.fillPincode(pincode);
    await this.chooseQuestion(question, answer);
    await this.savePincodeFormSuccessfully();
  }

  async fillPincode(pincode: string) {
    await this.pincode().fill(pincode);
  }

  pincode(): Locator {
    return this.page.getByLabel("Enter pincode");
  }

  async chooseQuestion(question: string, answer: string) {
    await this.theSecurityQuestionDropdown().selectOption(question);
    await this.fillAnswer(answer);
  }

  theSecurityQuestionDropdown(): Locator {
    return this.page.getByLabel("Choose question");
  }

  async fillOwnQuestion(ownQuestion) {
    await this.theSecurityQuestionDropdown().selectOption("Own question");
    await this.page.locator("input[name^='Client'][name$='[question]']").fill(ownQuestion);
  }

  async fillAnswer(answer: string) {
    await this.page.getByLabel("Answer").fill(answer);
  }

  async savePincodeFormSuccessfully() {
    await this.savePincodeFormWithMessage("Pincode settings were updated");
  }

  async savePincodeFormWithMessage(message: string) {
    await this.clickSaveButton();
    await this.getForm().waitFor({ state: "hidden" });
    await this.hasNotification(message);
    await this.closeNotification();
  }

  async clickSaveButton() {
    await this.page.locator("button:has-text(\"Save\")").click();
  }

  async disablePinUsingPincode(pincode: string) {
    this.loadPincodeForm();
    await this.fillPincode(pincode);
    await this.savePincodeFormSuccessfully();
  }

  async hasNotification(message: string) {
    await this.alert.hasText(message);
  }

  async closeNotification() {
    await this.alert.close();
  }

  async disablePinUsingAnswer(question: string, answer: string) {
    this.loadPincodeForm();
    await this.page.getByRole("link", { name: "Forgot pincode?" }).click();
    await this.page.getByLabel(question).fill(answer);
    await this.savePincodeFormSuccessfully();
  }
}
