import { expect, Locator, Page } from "@playwright/test";
import { InputValue } from "@hipanel-module-client/e2e/admin/ip-address-restrictions.spec";
import PincodeForm from "@hipanel-module-client/helper/PincodeForm";

export default class ClientView {
  private page: Page;
  private detailMenuFunctionsLocator: Locator;

  constructor(page: Page) {
    this.page = page;
    this.detailMenuFunctionsLocator = page.locator(".profile-usermenu .nav");
  }

  async gotoClientView(userId: string, userName: string) {
    await this.page.goto(`/client/client/view?id=${userId}`);
    await expect(this.page).toHaveTitle(`${userName}`);
  }

  async checkVisibleModalRestrictElements(elements: Array<any>) {
    await expect(this.page.locator("h4:has-text(\"IP address restrictions\")")).toBeVisible();
    for (let i = 0; i < elements.length; i++) {
      await expect(this.page.locator(`.modal-content :text("${elements[i].text}")`)).toBeVisible();
    }
  }

  async checkErrorModalRestrictInputValue(input: InputValue, userId: string) {
    await expect(this.page.locator("h4:has-text(\"IP address restrictions\")")).toBeVisible();
    await this.page.locator(`input[name="Client[${userId}][${input.fieldName}]"]`).fill(input.text);
    await this.page.locator(".callout").click();
    await expect(this.page.locator(`.modal-content :text("${input.errorMessage}")`)).toBeVisible();
  }

  async fillFormModalRestrictValidInputValue(input, userId: string) {
    await expect(this.page.locator("h4:has-text(\"IP address restrictions\")")).toBeVisible();
    await this.page.locator(`input[name="Client[${userId}][allowed_ips]"]`).fill(
      input.allowedIpsField ? input.allowedIpsField.concat(", 0.0.0.0/0") : "",
    );
    await this.page.locator(`input[name="Client[${userId}][sshftp_ips]"]`).fill(
      input.sshFtpIpsField ? input.sshFtpIpsField.concat(", 0.0.0.0/0") : "",
    );
  }

  async checkFormModalRestrictInputValue(input, userId: string) {
    await expect(this.page.locator("h4:has-text(\"IP address restrictions\")")).toBeVisible();
    let expectedValue = input.allowedIpsField ? input.allowedIpsField.concat(", 0.0.0.0/0") : "";
    await expect(this.page.locator(`input[name="Client[${userId}][allowed_ips]"]`)).toHaveValue(expectedValue);
    expectedValue = input.sshFtpIpsField ? input.sshFtpIpsField.concat(", 0.0.0.0/0") : "";
    await expect(this.page.locator(`input[name="Client[${userId}][sshftp_ips]"]`)).toHaveValue(expectedValue);
  }

  detailMenuItem(item: string): Locator {
    return this.detailMenuFunctionsLocator.locator(`:scope a:text("${item}")`);
  }

  getPincodeForm() {
    return new PincodeForm(this.page, this);
  }
}
