import { Page } from "@playwright/test";
import Select2 from "@hipanel-core/input/Select2";
import { Alert } from "@hipanel-core/shared/ui/components";
import Input from "@hipanel-core/input/Input";
import { Blacklist } from "@hipanel-module-client/types";

export default class BlacklistForm {
  private page: Page;
  private blackCategory: BlacklistCategoryInterface;

  constructor(page: Page, blackCategory: BlacklistCategoryInterface) {
    this.page = page;
    this.blackCategory = blackCategory;
  }

  async fill(blacklist: Blacklist) {
    if (blacklist.showMessage === "Yes") {
      await this.page.check(`#${this.blackCategory.getName()}-show_message`);
    }

    await Input.field(this.page, `#${this.blackCategory.getName()}-name`).setValue(blacklist.name);
    await Select2.field(this.page, `#${this.blackCategory.getName()}-type`).setValue(blacklist.type);
    await Input.field(this.page, `#${this.blackCategory.getName()}-message`).setValue(blacklist.message);
  }

  async save() {
    await this.page.locator("text=Save").click();
  }

  async create() {
    await this.page.click("button.btn.btn-success[type=\"submit\"]");
  }

  async seeSuccessBlacklistCreatingAlert() {
    await Alert.on(this.page).hasText(`${this.blackCategory.getLabel()} was created successfully`);
  }

  async getSavedBlacklistId(): Promise<string> {
    const currentUrl = this.page.url();
    const url = new URL(currentUrl);

    return url.searchParams.get("id");
  }
}
