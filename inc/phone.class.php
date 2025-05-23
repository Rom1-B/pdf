<?php

/**
 *  -------------------------------------------------------------------------
 *  LICENSE
 *
 *  This file is part of PDF plugin for GLPI.
 *
 *  PDF is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU Affero General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  PDF is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 *  GNU Affero General Public License for more details.
 *
 *  You should have received a copy of the GNU Affero General Public License
 *  along with Reports. If not, see <http://www.gnu.org/licenses/>.
 *
 * @author    Nelly Mahu-Lasson, Remi Collet, Teclib
 * @copyright Copyright (c) 2009-2022 PDF plugin team
 * @license   AGPL License 3.0 or (at your option) any later version
 * @link      https://github.com/pluginsGLPI/pdf/
 * @link      http://www.glpi-project.org/
 * @package   pdf
 * @since     2009
 *             http://www.gnu.org/licenses/agpl-3.0-standalone.html
 *  --------------------------------------------------------------------------
 */

class PluginPdfPhone extends PluginPdfCommon
{
    public static $rightname = 'plugin_pdf';

    public function __construct(CommonGLPI $obj = null)
    {
        $this->obj = ($obj ? $obj : new Phone());
    }

    public function defineAllTabsPDF($options = [])
    {
        $onglets = parent::defineAllTabsPDF($options);
        unset($onglets['Appliance_Item$1']);
        unset($onglets['Impact$1']);
        unset($onglets['Glpi\Socket$1']);
        unset($onglets['Item_RemoteManagement$1']);

        return $onglets;
    }

    public static function pdfMain(PluginPdfSimplePDF $pdf, Phone $item)
    {
        PluginPdfCommon::mainTitle($pdf, $item);

        PluginPdfCommon::mainLine($pdf, $item, 'name-status');
        PluginPdfCommon::mainLine($pdf, $item, 'location-type');
        PluginPdfCommon::mainLine($pdf, $item, 'tech-manufacturer');
        PluginPdfCommon::mainLine($pdf, $item, 'group-model');
        PluginPdfCommon::mainLine($pdf, $item, 'contactnum-serial');
        PluginPdfCommon::mainLine($pdf, $item, 'contact-otherserial');
        PluginPdfCommon::mainLine($pdf, $item, 'user-management');


        $pdf->displayLine(
            '<b><i>' . sprintf(
                __('%1$s: %2$s'),
                __('Group') . '</i></b>',
                Dropdown::getDropdownName('glpi_groups', $item->fields['groups_id']),
            ),
            '<b><i>' . sprintf(
                __('%1$s: %2$s'),
                __('UUID') . '</i></b>',
                $item->fields['uuid'],
            ),
        );

        $pdf->displayLine(
            '<b><i>' . sprintf(__('%1$s: %2$s'), __('Brand') . '</i></b>', $item->fields['brand']),
            '<b><i>' . sprintf(
                __('%1$s: %2$s'),
                _x('quantity', 'Number of lines') . '</i></b>',
                $item->fields['number_line'],
            ),
        );

        $opts = ['have_headset' => __('Headset'),
            'have_hp'           => __('Speaker')];
        foreach ($opts as $key => $val) {
            if (!$item->fields[$key]) {
                unset($opts[$key]);
            }
        }

        $pdf->displayLine(
            '<b><i>' . sprintf(
                __('%1$s: %2$s'),
                __('Power supply') . '</i></b>',
                Dropdown::getYesNo($item->fields['phonepowersupplies_id']),
            ),
            '<b><i>' . sprintf(
                __('%1$s: %2$s'),
                __('Flags') . '</i></b>',
                (count($opts) ? implode(', ', $opts) : __('None')),
            ),
        );

        PluginPdfCommon::mainLine($pdf, $item, 'comment');

        $pdf->displaySpace();
    }

    public static function displayTabContentForPDF(PluginPdfSimplePDF $pdf, CommonGLPI $item, $tab)
    {
        switch ($tab) {
            default:
                return false;
        }
    }
}
