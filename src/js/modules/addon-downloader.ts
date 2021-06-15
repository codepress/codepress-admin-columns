import axios, {AxiosPromise} from "axios";
import {mapDataToFormData} from "../helpers/global";
import Nanobus from "nanobus";

declare const ajaxurl: string;

type DownloadResponse = {
    data : {
        activated: boolean,
        status: string
    },
    success: boolean
}

export default class AddonDownloader {

    network_admin: boolean
    slug: string
    nonce: string
    events: Nanobus

    constructor(slug: string, network_admin: boolean, nonce: string) {
        this.slug = slug;
        this.network_admin = network_admin;
        this.nonce = nonce;
    }

    download(): AxiosPromise<DownloadResponse> {
        return axios.post(ajaxurl, mapDataToFormData({
            action: 'acp-install-addon',
            plugin_name: this.slug,
            network_wide: this.network_admin,
            _ajax_nonce: this.nonce
        }));
    }


}