export interface Blacklist {
  id?: string | null;
  name: string;
  type: string;
  showMessage: "Yes" | "No";
  message?: string;
  client?: string;
  created?: string;
}
