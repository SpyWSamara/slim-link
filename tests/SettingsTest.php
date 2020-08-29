<?php

declare(strict_types=1);

namespace Tests;

use App\Exceptions\SettingsSetError;
use App\Exceptions\SettingsUnsetError;
use App\Settings;
use PHPUnit\Framework\TestCase;

class SettingsTest extends TestCase
{
    public function testSetValue()
    {
        $this->expectException(SettingsSetError::class);

        $settings = new Settings([]);
        $settings['setted'] = 'data';
    }

    public function testUnsetValue()
    {
        $this->expectException(SettingsUnsetError::class);

        $settings = new Settings(['test' => 'value']);
        unset($settings['test']);
    }

    /**
     * @dataProvider settingsDataProvider
     *
     * @return void
     */
    public function testIssetKeys($settingsParams, $key, $expected)
    {
        $settings = new Settings($settingsParams);
        $expected = !\in_array($key, ['notexists', 'not.exists']);
        $this->assertSame($expected, isset($settings[$key]));
    }

    /**
     * @dataProvider settingsDataProvider
     *
     * @return void
     */
    public function testGetKeys($settingsParams, $key, $expected)
    {
        $settings = new Settings($settingsParams);
        $this->assertSame($expected, $settings[$key]);
    }

    public function settingsDataProvider()
    {
        $settings = [
            'level' => [
                'one' => 'oneLevelValue',
                'two' => 'twolevelvalue',
                'indexValue0',
                'CaseTest' => 'Case Sensitive',
                'casetest' => 'case insensitive',
                'emptyValue' => [],
                'indexValue1',
            ],
            'nullValue' => null,
            'trueValue' => true,
            'falseValue' => false,
            'emmptyArrayValue' => [],
        ];

        return [
            [$settings, 'nullValue', null],
            [$settings, 'trueValue', true],
            [$settings, 'falseValue', false],
            [$settings, 'emmptyArrayValue', []],
            [$settings, 'level', $settings['level']],
            [$settings, 'level.one', 'oneLevelValue'],
            [$settings, 'level.two', 'twolevelvalue'],
            [$settings, 'level.0', 'indexValue0'],
            [$settings, 'level.1', 'indexValue1'],
            [$settings, 'level.CaseTest', 'Case Sensitive'],
            [$settings, 'level.casetest', 'case insensitive'],
            [$settings, 'level.emptyValue', []],
            [$settings, 'notexists', null],
            [$settings, 'not.exists', null],
        ];
    }
}
