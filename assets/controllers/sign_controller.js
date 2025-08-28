import { Controller } from "@hotwired/stimulus";
import SignaturePad from "signature_pad";

export default class extends Controller {
  static targets = ["pad"];

  connect() {
    this.signaturePad = new SignaturePad(this.padTarget);
  }

  submit(event) {
    event.formData.append('signature-image', this.signaturePad.toDataURL());
  }
}
